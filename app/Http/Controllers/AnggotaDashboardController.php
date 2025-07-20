<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:anggota']);
    }

    /**
     * Show the application dashboard for anggota.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Debug: Periksa role user (hapus setelah debug)
        dd('User authenticated: ' . $user->name . ' | Role: "' . $user->role . '"');

        return view('anggota.dashboard');
    }
}
