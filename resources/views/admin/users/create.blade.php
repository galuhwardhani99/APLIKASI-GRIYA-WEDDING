@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h1 class="h3 font-weight-bold">Tambah Akun Baru</h1>
    </div>

    <div class="card shadow-sm border-0 col-md-8">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">No. WhatsApp / Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Role / Peran</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection