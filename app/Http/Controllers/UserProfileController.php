<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = User::normalizePhone($request->phone);
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil akun Anda berhasil diperbarui!');
    }
}