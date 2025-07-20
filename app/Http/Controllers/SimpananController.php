<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SimpananController extends Controller
{
    // Constants untuk jenis simpanan
    const JENIS_SIMPANAN_POKOK = 1;
    const JENIS_SIMPANAN_WAJIB = 4;
    const JENIS_SIMPANAN_SUKARELA = 5;
    const JENIS_SIMPANAN_INSIDENTAL = 6;

    // Constants untuk nominal tetap
    const NOMINAL_SIMPANAN_POKOK = 250000;
    const NOMINAL_SIMPANAN_WAJIB = 20000;

    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        $query = DB::table('simpanan')
            ->select([
                'simpanan.id as simpanan_id',
                'simpanan.kodeTransaksiSimpanan',
                'simpanan.tanggal_simpanan',
                'simpanan.jml_simpanan',
                'jenis_simpanan.nama as jenis_simpanan_nama',
                'users.name as created_by_name',
                '_anggota.name as anggota_name'
            ])
            ->join('users', 'users.id', '=', 'simpanan.created_by')
            ->join('_anggota', '_anggota.id', '=', 'simpanan.id_anggota')
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan');

        // Filter berdasarkan tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('simpanan.tanggal_simpanan', [$startDate, $endDate]);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('simpanan.kodeTransaksiSimpanan', 'LIKE', "%{$search}%")
                  ->orWhere('_anggota.name', 'LIKE', "%{$search}%");
            });
        }

        $simpanan = $query->orderBy('simpanan.id', 'DESC')->paginate(5);
        $namaNasabah = DB::table('_anggota')->select('id', 'name')->orderBy('name')->get();
        $jenisSimpanan = DB::table('jenis_simpanan')->select('id', 'nama')->orderBy('nama')->get();

        $kodeTransaksiSimpanan = $this->generateTransactionCode();

        return view('backend.simpanan.index', compact(
            'simpanan',
            'startDate',
            'endDate',
            'search',
            'namaNasabah',
            'kodeTransaksiSimpanan',
            'jenisSimpanan'
        ));
    }

    public function create()
    {
        $namaNasabah = DB::table('_anggota')->select('id', 'name')->orderBy('name')->get();
        $jenisSimpanan = DB::table('jenis_simpanan')->select('id', 'nama')->orderBy('nama')->get();
        $kodeTransaksiSimpanan = $this->generateTransactionCode();

        return view('backend.simpanan.create', compact(
            'namaNasabah',
            'kodeTransaksiSimpanan',
            'jenisSimpanan'
        ));
    }

    public function store(SimpananRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validasi jenis simpanan
            $jenisSimpanan = $this->getJenisSimpanan($request->id_jenis_simpanan);
            if (!$jenisSimpanan) {
                return redirect()->back()
                    ->withErrors(['id_jenis_simpanan' => 'Jenis simpanan tidak valid.'])
                    ->withInput();
            }

            // Validasi dan hitung jumlah simpanan
            $jmlSimpanan = $this->calculateSimpananAmount($request, $jenisSimpanan);
            if (is_array($jmlSimpanan)) {
                return redirect()->back()
                    ->withErrors($jmlSimpanan)
                    ->withInput();
            }

            // Upload bukti pembayaran
            $imagePath = $this->handleImageUpload($request);

            // Simpan data simpanan
            $simpananId = DB::table('simpanan')->insertGetId([
                'kodeTransaksiSimpanan' => $request->kodeTransaksiSimpanan,
                'tanggal_simpanan' => $request->tanggal_simpanan,
                'id_anggota' => $request->id_anggota,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'jml_simpanan' => $jmlSimpanan,
                'bukti_pembayaran' => $imagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update saldo anggota
            $this->updateMemberBalance($request->id_anggota);

            DB::commit();

            return redirect()->route('simpanan')
                ->with('message', 'Data Simpanan Berhasil Disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saving simpanan: ' . $e->getMessage());

            return redirect()->route('simpanan')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $detailSimpanan = DB::table('simpanan')
            ->select([
                'simpanan.jml_simpanan as jmlh',
                'simpanan.kodeTransaksiSimpanan as kode',
                'simpanan.tanggal_simpanan as tgl',
                'simpanan.bukti_pembayaran as bukti',
                'users_created.name as created_by',
                'users_updated.name as updated_by',
                '_anggota.name as anggota_name',
                '_anggota.nip as anggota_nip',
                '_anggota.image as anggota_image',
                '_anggota.telphone as anggota_telphone',
                '_anggota.alamat as anggota_alamat',
                '_anggota.pekerjaan as anggota_pekerjaan',
                '_anggota.agama as anggota_agama',
                'jenis_simpanan.nama as jenis_simpanan_nama'
            ])
            ->join('_anggota', '_anggota.id', '=', 'simpanan.id_anggota')
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan')
            ->join('users as users_created', 'users_created.id', '=', 'simpanan.created_by')
            ->leftJoin('users as users_updated', 'users_updated.id', '=', 'simpanan.updated_by')
            ->where('simpanan.id', $id)
            ->first();

        if (!$detailSimpanan) {
            return redirect()->route('simpanan')
                ->with('error', 'Data simpanan tidak ditemukan.');
        }

        return view('backend.simpanan.show', compact('detailSimpanan'));
    }

    public function edit($id)
    {
        $simpanedit = DB::table('simpanan')->where('id', $id)->first();

        if (!$simpanedit) {
            return redirect()->route('simpanan')
                ->with('error', 'Data simpanan tidak ditemukan.');
        }

        $namaNasabah = DB::table('_anggota')->select('id', 'name')->orderBy('name')->get();
        $jenisSimpanan = DB::table('jenis_simpanan')->select('id', 'nama')->orderBy('nama')->get();

        return view('backend.simpanan.edit', compact(
            'simpanedit',
            'namaNasabah',
            'jenisSimpanan'
        ));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:_anggota,id',
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id',
            'jml_simpanan' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Ambil data simpanan lama
            $oldSimpanan = DB::table('simpanan')->where('id', $id)->first();
            if (!$oldSimpanan) {
                return redirect()->route('simpanan')
                    ->with('error', 'Data simpanan tidak ditemukan.');
            }

            // Data untuk diperbarui
            $updateData = [
                'id_anggota' => $request->id_anggota,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'jml_simpanan' => $request->jml_simpanan,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ];

            // Handle file upload
            if ($request->hasFile('bukti_pembayaran')) {
                // Hapus file lama
                $this->deleteOldImage($oldSimpanan->bukti_pembayaran);

                // Upload file baru
                $updateData['bukti_pembayaran'] = $this->handleImageUpload($request);
            }

            // Update data simpanan
            DB::table('simpanan')->where('id', $id)->update($updateData);

            // Update saldo anggota
            $this->updateMemberBalance($request->id_anggota);

            // Jika anggota berubah, update saldo anggota lama juga
            if ($oldSimpanan->id_anggota != $request->id_anggota) {
                $this->updateMemberBalance($oldSimpanan->id_anggota);
            }

            DB::commit();

            return redirect()->route('simpanan')
                ->with('message', 'Data simpanan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating simpanan: ' . $e->getMessage());

            return redirect()->route('simpanan')
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $simpanan = DB::table('simpanan')->where('id', $id)->first();
            if (!$simpanan) {
                return redirect()->route('simpanan')
                    ->with('error', 'Data simpanan tidak ditemukan.');
            }

            // Hapus file bukti pembayaran
            $this->deleteOldImage($simpanan->bukti_pembayaran);

            // Hapus data simpanan
            DB::table('simpanan')->where('id', $id)->delete();

            // Update saldo anggota
            $this->updateMemberBalance($simpanan->id_anggota);

            DB::commit();

            return redirect()->route('simpanan')
                ->with('message', 'Data simpanan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting simpanan: ' . $e->getMessage());

            return redirect()->route('simpanan')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function cetak(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = DB::table('simpanan')
            ->select([
                'simpanan.id as simpanan_id',
                'simpanan.kodeTransaksiSimpanan',
                'simpanan.tanggal_simpanan',
                'simpanan.jml_simpanan',
                'jenis_simpanan.nama as jenis_simpanan_nama',
                'users.name as created_by_name',
                '_anggota.name as anggota_name'
            ])
            ->join('users', 'users.id', '=', 'simpanan.created_by')
            ->join('_anggota', '_anggota.id', '=', 'simpanan.id_anggota')
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan');

        if ($startDate && $endDate) {
            $query->whereBetween('simpanan.tanggal_simpanan', [$startDate, $endDate]);
        }

        $simpanan = $query->orderBy('simpanan.id', 'DESC')->get();

        $pdf = PDF::loadView('backend.laporan.simpanan', compact('simpanan', 'startDate', 'endDate'));
        $pdf->setPaper('A4', 'landscape');

        $filename = 'laporan_simpanan_' . date('Y-m-d_H-i-s') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Generate kode transaksi baru
     */
    private function generateTransactionCode()
    {
        $lastTransaction = DB::table('simpanan')
            ->where('kodeTransaksiSimpanan', 'LIKE', 'SMP-%')
            ->orderBy('kodeTransaksiSimpanan', 'desc')
            ->first();

        $newTransactionNumber = $lastTransaction ?
            (int) substr($lastTransaction->kodeTransaksiSimpanan, 4) + 1 : 1;

        return 'SMP-' . str_pad($newTransactionNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Ambil data jenis simpanan
     */
    private function getJenisSimpanan($id)
    {
        return DB::table('jenis_simpanan')->where('id', $id)->first();
    }

    /**
     * Hitung jumlah simpanan berdasarkan jenis
     */
    private function calculateSimpananAmount($request, $jenisSimpanan)
    {
        switch ($jenisSimpanan->id) {
            case self::JENIS_SIMPANAN_POKOK:
                // Cek apakah anggota sudah memiliki simpanan pokok
                $existingSimpananPokok = DB::table('simpanan')
                    ->where('id_anggota', $request->id_anggota)
                    ->where('id_jenis_simpanan', self::JENIS_SIMPANAN_POKOK)
                    ->exists();

                if ($existingSimpananPokok) {
                    return ['id_jenis_simpanan' => 'Anggota sudah memiliki simpanan pokok.'];
                }

                return self::NOMINAL_SIMPANAN_POKOK;

            case self::JENIS_SIMPANAN_WAJIB:
                return self::NOMINAL_SIMPANAN_WAJIB;

            case self::JENIS_SIMPANAN_SUKARELA:
            case self::JENIS_SIMPANAN_INSIDENTAL:
                if ($request->jml_simpanan <= 0) {
                    $jenis = $jenisSimpanan->id == self::JENIS_SIMPANAN_SUKARELA ? 'sukarela' : 'insidental';
                    return ['jml_simpanan' => "Jumlah simpanan {$jenis} harus lebih dari 0."];
                }
                return $request->jml_simpanan;

            default:
                return $request->jml_simpanan;
        }
    }

    /**
     * Handle upload gambar bukti pembayaran
     */
    private function handleImageUpload($request)
    {
        if (!$request->hasFile('bukti_pembayaran')) {
            return null;
        }

        $image = $request->file('bukti_pembayaran');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/img'), $imageName);

        return 'assets/img/' . $imageName;
    }

    /**
     * Hapus gambar lama
     */
    private function deleteOldImage($imagePath)
    {
        if ($imagePath && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }
    }

    /**
     * Update saldo anggota dan status
     */
    private function updateMemberBalance($anggotaId)
    {
        // Hitung total simpanan anggota
        $totalSimpanan = DB::table('simpanan')
            ->where('id_anggota', $anggotaId)
            ->sum('jml_simpanan');

        // Update saldo anggota
        DB::table('_anggota')
            ->where('id', $anggotaId)
            ->update([
                'saldo' => $totalSimpanan,
                'status_anggota' => $totalSimpanan > 0 ? 1 : 0,
                'updated_at' => now()
            ]);

        // Update total saldo keseluruhan
        $grandTotalSaldo = DB::table('simpanan')->sum('jml_simpanan');
        DB::table('total_saldo_anggota')->updateOrInsert(
            [],
            [
                'gradesaldo' => $grandTotalSaldo,
                'updated_at' => now()
            ]
        );
    }
}
