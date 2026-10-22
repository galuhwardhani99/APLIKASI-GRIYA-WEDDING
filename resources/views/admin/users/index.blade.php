@extends('layouts.admin') {{-- Sesuaikan dengan nama file layout kalian, misal 'layouts.app' --}}

@section('content')
<style>
    /* Styling Kustom Tabel Kelola Akun */
    .user-card-section {
        background-color: #FFFFFF;
        border: 1px solid #EFE8DE;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        margin-top: 20px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .custom-table th {
        text-align: left;
        padding: 14px 16px;
        font-size: 0.75rem;
        color: #C58F43; /* Gold primary */
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #EFE8DE;
        background-color: #FAFAFA;
        font-weight: 700;
    }

    .custom-table td {
        padding: 16px;
        font-size: 0.9rem;
        border-bottom: 1px solid #EFE8DE;
        color: #241A16;
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background-color: #FDFBF7;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Status / Role Badge */
    .role-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: capitalize;
    }
    .role-admin {
        background-color: #FFF3E0;
        color: #E65100;
        border: 1px solid #FFE0B2;
    }
    .role-client {
        background-color: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #C8E6C9;
    }

    /* Buttons Style */
    .btn-gold-add {
        background-color: #C58F43;
        color: #FFFFFF !important;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-gold-add:hover {
        background-color: #A87632;
    }

    .btn-action-edit {
        color: #B9770E;
        background-color: #FEF5E7;
        border: 1px solid #FDEBD0;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }
    .btn-action-edit:hover {
        background-color: #FDEBD0;
    }

    .btn-action-delete {
        color: #DC2626;
        background-color: #FEF2F2;
        border: 1px solid #FCA5A5;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }
    .btn-action-delete:hover {
        background-color: #FEE2E2;
    }
</style>

<!-- Dashboard Header Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="font-family: 'Playfair Display', serif; color: #241A16; font-size: 1.6rem; font-weight: 700;">Kelola Akun Pengguna</h1>
        <p style="font-size: 0.85rem; color: #8C8279; margin-top: 4px;">Daftar seluruh akun admin dan client yang terdaftar.</p>

<!-- Container Tabel Bergaya Card -->
<div class="user-card-section">
    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. WhatsApp</th>
                    <th style="text-align: center;">Role</th>
                    <th style="text-align: center; width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td style="text-align: center; color: #8C8279; font-weight: 600;">{{ $index + 1 }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td style="color: #8C8279;">{{ $user->email ?? '-' }}</td>
                        <td style="color: #8C8279;">{{ $user->phone ?? '-' }}</td>
                        <td style="text-align: center;">
                            <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : 'role-client' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action-edit">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-delete">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #8C8279; padding: 30px;">Belum ada data akun yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SweetAlert2 Notifikasi Sukses --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#C58F43',
            background: '#FFFFFF',
            color: '#241A16'
        });
    });
</script>
@endif
@endsection