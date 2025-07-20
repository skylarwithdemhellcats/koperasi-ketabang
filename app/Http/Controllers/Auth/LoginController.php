<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return '/admin/dashboard';
        } elseif ($role === 'anggota') {
            return '/';
        } else {
            return '/home'; // fallback kalau rolenya tidak dikenali
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
