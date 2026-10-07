<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $input = $request->input('login');

        // Cek apakah input berupa Email atau No. WA
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $input, 'password' => $request->password];
        } else {
            $normalizedPhone = User::normalizePhone($input);
            $credentials = ['phone' => $normalizedPhone, 'password' => $request->password];
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Berhasil masuk! Selamat datang kembali.');
        }

        return back()->withErrors([
            'login' => 'Email/No. WhatsApp atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
{
    Auth::logout();

    // Matikan sesi lama
    $request->session()->invalidate();

    // Buat CSRF token baru untuk form selanjutnya
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Berhasil keluar akun.');
}
}