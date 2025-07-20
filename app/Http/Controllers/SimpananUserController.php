<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpananUserController extends Controller
{
    public function index()
    {
        return view('anggota.anggota_simpanan.index'); // Lihat Simpanan
    }

    public function create()
    {
        return view('anggota.anggota_simpanan.create');
    }

    public function main()
    {
        return view('anggota.anggota_simpanan.main');
    }

    public function show()
    {
        return view('anggota.anggota_simpanan.show');
    }
}
