<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JurnalUmum;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class JurnalUmumController extends Controller
{
    public function create()
    {
        $akuns = Account::orderBy('kode_akun')->get();
        return view('backend.jurnal.create', compact('akuns'));
    }

    public function exportPdf()
    {
        $jurnals = JurnalUmum::with('details.akun')->orderBy('tanggal')->get();

        $pdf = PDF::loadView('backend.jurnal.export_pdf', compact('jurnals'))
                    ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-jurnal-umum.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'akun_id' => 'required|array',
            'debit' => 'required|array',
            'kredit' => 'required|array',
        ]);

        // Validasi total debit = kredit
        $totalDebit = collect($request->debit)->sum();
        $totalKredit = collect($request->kredit)->sum();

        if ($totalDebit != $totalKredit) {
            return back()->with('error', 'Total debit dan kredit harus balance.');
        }

        DB::transaction(function () use ($request) {
            $tanggal = $request->tanggal;
            $tahun = date('Y', strtotime($tanggal));

            // Ambil nomor terakhir di tahun yang sama
            $last = JurnalUmum::whereYear('tanggal', $tahun)
                ->orderBy('no_jurnal', 'desc')
                ->first();

            if ($last) {
                // Ambil 4 digit terakhir dan tambahkan 1
                $lastNumber = (int) substr($last->no_jurnal, -4);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Format: JU-2025-0004
            $noJurnal = 'JU-' . $tahun . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $jurnal = JurnalUmum::create([
                'no_jurnal' => $noJurnal,
                'tanggal' => $tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->akun_id as $index => $akunId) {
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'akun_id' => $akunId,
                    'debit' => $request->debit[$index] ?? 0,
                    'kredit' => $request->kredit[$index] ?? 0,
                ]);
            }
        });

        return redirect()->route('laporan.jurnal_umum')->with('success', 'Jurnal berhasil disimpan.');
    }

}
