<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        ], [
            'login.required'    => 'Email atau nomor WhatsApp wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $login = trim($request->input('login'));
        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

        $credentials = [
            $isEmail ? 'email' : 'phone' => $isEmail ? strtolower($login) : User::normalizePhone($login),
            'password' => $request->input('password'),
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'Email/No. WhatsApp atau kata sandi salah.',
            ]);
        }

        $request->session()->regenerate();

        // Admin & client sama-sama masuk ke beranda
        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}