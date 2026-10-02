<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => User::normalizePhone((string) $request->input('phone')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:2000'],
            'password' => ['required', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        if (! preg_match('/^0\d{9,13}$/', $data['phone'])) {
            throw ValidationException::withMessages([
                'phone' => 'Masukkan nomor HP yang valid (contoh: 081234567890).',
            ]);
        }

        if (User::where('phone', $data['phone'])->exists()) {
            throw ValidationException::withMessages([
                'phone' => 'Nomor HP sudah terdaftar.',
            ]);
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => $data['password'],
            'role' => 'client',
        ]);

        return redirect()->route('home')
            ->with('status', 'Pendaftaran berhasil. Silakan login dengan email atau nomor HP dan kata sandi Anda.');
    }
}
