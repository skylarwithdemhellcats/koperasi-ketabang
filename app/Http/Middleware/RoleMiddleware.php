<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Debug: uncomment untuk debug
        // dd('User Role: "' . $user->role . '" | Required: "' . $role . '"');

        // Check role (case insensitive)
        if (strtolower($user->role) !== strtolower($role)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
