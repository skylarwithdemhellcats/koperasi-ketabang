<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('kode_akun', 'asc')->get();
        return view('akun.index', compact('accounts'));
    }


    public function create()
    {
        return view('akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required',
            'tipe' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
        ]);

        //prefix berdasarkan kategori
        $prefix = match ($request->kategori) {
            'Aset' => '1',
            'Liabilitas' => '2',
            'Pendapatan' => '3',
            'Beban' => '4',
            'Ekuitas' => '5',
            default => '9', // fallback
        };

        // Ambil Kode AKun
        $lastAccount = Account::where('kode_akun', 'like', $prefix . '%')
            ->orderByDesc('kode_akun')
            ->first();

        // Kode baru
        $newKode = $lastAccount
            ? strval(intval($lastAccount->kode_akun) + 1)
            : $prefix . '11'; // Default awal 111, 211, 311, dst

        // Simpan akun baru
        Account::create([
            'kode_akun' => $newKode,
            'nama_akun' => $request->nama_akun,
            'tipe' => $request->tipe,
            'kategori' => $request->kategori,
            'status' => $request->has('status'),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(Account $akun)
    {
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, Account $akun)
    {
        $request->validate([
            'kode_akun' => 'required|unique:accounts,kode_akun,' . $akun->id,
            'nama_akun' => 'required',
            'tipe' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
        ]);

        $akun->update([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'tipe' => $request->tipe,
            'kategori' => $request->kategori,
            'status' => $request->has('status'),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Account $akun)
    {
        $akun->delete();
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
