<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenarikanUserController extends Controller
{
    public function index()
    {
        return view('anggota.anggota_penarikan.index'); // Lihat penarikan
    }

    public function create()
    {
        return view('anggota.anggota_penarikan.create');
    }

    public function main()
    {
        return view('anggota.anggota_penarikan.main');
    }

    public function show()
    {
        return view('anggota.anggota_penarikan.show');
    }
}