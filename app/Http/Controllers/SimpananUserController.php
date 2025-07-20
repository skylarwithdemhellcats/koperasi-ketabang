<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpananUserController extends Controller
{
    public function index()
    {
        return view('simpanan_user.index'); // Lihat Simpanan
    }

    public function create()
    {
        return view('simpanan_user.create');
    }

    public function main()
    {
        return view('simpanan_user.main');
    }

    public function show()
    {
        return view('simpanan_user.show');
    }
}
