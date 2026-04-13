<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. PROSES LOGIN
        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ], $request->remember)) {

            throw ValidationException::withMessages([
                'username' => 'Username atau password salah.',
            ]);
        }

        // 3. REGENERATE SESSION
        $request->session()->regenerate();

        // 4. REDIRECT BERDASARKAN ROLE
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'kasir' => redirect()->intended('/kasir/dashboard'),
            default => abort(403, 'Role tidak dikenali.'),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}