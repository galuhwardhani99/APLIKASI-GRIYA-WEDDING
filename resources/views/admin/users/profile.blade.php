@extends('layouts.app') {{-- Sesuaikan dengan layout client kalian --}}

@section('content')
<style>
    .profile-container {
        max-width: 650px;
        margin: 40px auto;
        padding: 0 16px;
    }
    .profile-card {
        background-color: #FFFFFF;
        border: 1px solid #EFE8DE;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #241A16;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #EFE8DE;
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #C58F43;
    }
    .btn-gold-save {
        background-color: #C58F43;
        color: #FFFFFF;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.2s;
    }
    .btn-gold-save:hover {
        background-color: #A87632;
    }
    .alert-success-custom {
        background-color: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #C8E6C9;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        margin-bottom: 20px;
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <h2 style="font-family: 'Playfair Display', serif; color: #241A16; font-size: 1.6rem; margin-bottom: 6px;">Pengaturan Akun</h2>
        <p style="font-size: 0.85rem; color: #8C8279; margin-bottom: 24px;">Kelola data diri dan kata sandi akun Anda.</p>

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <small style="color: #DC2626;">{{ $message }}</small> @enderror
            </div>

            {{-- Email (Readonly / Tidak bisa di-edit) --}}
            <div class="form-group">
                <label>Alamat Email <small style="color: #8C8279;">(Sesuai registrasi)</small></label>
                <input type="email" class="form-control" value="{{ $user->email }}" readonly style="background-color: #FAFAFA; color: #8C8279; cursor: not-allowed;">
            </div>

            {{-- No. WhatsApp --}}
            <div class="form-group">
                <label>No. WhatsApp / Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" required>
                @error('phone') <small style="color: #DC2626;">{{ $message }}</small> @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat domisili atau alamat acara Anda">{{ old('address', $user->address) }}</textarea>
                @error('address') <small style="color: #DC2626;">{{ $message }}</small> @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid #EFE8DE; margin: 28px 0 20px 0;">

            <h4 style="font-size: 1rem; color: #241A16; margin-bottom: 4px;">Ubah Password</h4>
            <p style="font-size: 0.8rem; color: #8C8279; margin-bottom: 16px;">Biarkan kosong jika tidak ingin mengganti password saat ini.</p>

            {{-- Password Baru --}}
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                @error('password') <small style="color: #DC2626;">{{ $message }}</small> @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn-gold-save">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection