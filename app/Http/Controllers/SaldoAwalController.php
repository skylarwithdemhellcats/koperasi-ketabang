<?php

namespace App\Http\Controllers;

use App\Models\SaldoAwal;
use App\Models\Account;
use Illuminate\Http\Request;

class SaldoAwalController extends Controller
{
    // Menampilkan form input saldo awal
    public function create()
    {
        $accounts = Account::all();
        return view('saldo_awal.create', compact('accounts'));
    }

    // Menyimpan data saldo awal ke database
    public function store(Request $request)
    {
        // Ambil "2025-07"
        $bulanTahun = explode('-', $request->bulan);
        $bulan = intval($bulanTahun[1] ?? 0);
        $tahun = intval($bulanTahun[0] ?? 0);

        // Merge ke request supaya validasi bisa jalan
        $request->merge([
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        $request->validate([
            'akun_id' => 'required|exists:accounts,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah' => 'required|numeric',
        ]);

        // Cek duplikat
        $existing = SaldoAwal::where('akun_id', $request->akun_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if ($existing) {
            return back()->with('error', 'Saldo awal untuk akun ini di bulan dan tahun tersebut sudah ada.');
        }

        SaldoAwal::create([
            'akun_id' => $request->akun_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('saldo-awal.create')->with('success', 'Saldo Awal berhasil disimpan.');
    }


    // Menampilkan daftar saldo awal
    public function index()
    {
        $data = SaldoAwal::with('akun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('saldo_awal.index', ['saldoAwal' => $data]);
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $saldo = SaldoAwal::findOrFail($id);
        $accounts = Account::all();
        return view('saldo_awal.edit', compact('saldo', 'accounts'));
    }

    // Menyimpan update
    public function update(Request $request, $id)
    {
        $request->validate([
            'akun_id' => 'required|exists:accounts,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah' => 'required|numeric',
        ]);

        $saldo = SaldoAwal::findOrFail($id);
        $saldo->update($request->all());

        return redirect()->route('saldo-awal.index')->with('success', 'Saldo Awal berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $saldo = SaldoAwal::findOrFail($id);
        $saldo->delete();

        return back()->with('success', 'Saldo Awal berhasil dihapus.');
    }
}
