@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
    <h1 class="auth-title">Buat Akun</h1>
    <p class="auth-subtitle">Daftar untuk melakukan reservasi layanan</p>

    <form method="POST" action="{{ route('register.store') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="input @error('name') is-invalid @enderror"
                   placeholder="Masukkan nama lengkap Anda" required autofocus>
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="input @error('email') is-invalid @enderror"
                   placeholder="Contoh: nama@email.com" autocomplete="email" required>
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="phone">Nomor HP / WhatsApp</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                   class="input @error('phone') is-invalid @enderror"
                   placeholder="Contoh: 081234567890" autocomplete="tel" required>
            @error('phone') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea id="address" name="address"
                      class="input input-textarea @error('address') is-invalid @enderror"
                      placeholder="Masukkan alamat lengkap" autocomplete="street-address" required>{{ old('address') }}</textarea>
            @error('address') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        @include('auth.partials.password')

        <button type="submit" class="btn-primary">REGISTER</button>
    </form>

    <div class="auth-footer">
        Sudah memiliki akun? <a href="{{ route('login') }}">Masuk Akun</a>
    </div>
@endsection