<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinjamanUserController extends Controller
{
    public function index()
    {
        return view('anggota.anggota_pinjaman.index'); // Lihat pinjaman
    }

    public function create()
    {
        return view('anggota.anggota_pinjaman.create');
    }

    public function main()
    {
        return view('anggota.anggota_pinjaman.main');
    }

    public function show()
    {
        return view('anggota.anggota_pinjaman.show');
    }
}
