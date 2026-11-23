@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Acara - Admin Griya Rias Elly Jr.')

@push('styles')
<style>
    .page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
    .page-sub { color: var(--text-muted); font-size: 0.9rem; }

    .badge-pending-count {
        background: #FEF2F2;
        color: #DC2626;
        border: 1px solid #FECACA;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    table.admin-jadwal-table {
        width: 100%;
        min-width: 860px;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    table.admin-jadwal-table th {
        text-align: left;
        padding: 15px 16px;
        background: #FCFAF8;
        color: var(--text-muted);
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
        border-bottom: 1px solid var(--border-color);
    }

    table.admin-jadwal-table td {
        padding: 16px;
        border-top: 1px solid #F0EBE6;
        vertical-align: middle;
        color: var(--text-dark);
    }

    .status-pill {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
    }
    .status-approved { background: #EAF6EE; color: #267145; }
    .status-pending { background: #FBF2E4; color: #8A6026; }
    .status-rejected { background: #FEF2F2; color: #991B1B; }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .btn-admin {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 7px;
        border: 0;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-validate { background: var(--gold-primary); color: #FFFFFF; }
    .btn-validate:hover { background: var(--gold-hover); }

    .btn-date { background: #F3F0EC; color: var(--text-dark); border: 1px solid var(--border-color); }
    .btn-date:hover { background: #EFE8DE; }

    .btn-wa { background: #16A34A; color: #FFFFFF; }
    .btn-wa:hover { background: #15803D; }

    .date-input-inline {
        padding: 6px 8px;
        border: 1px solid var(--border-color);
        border-radius: 7px;
        font-size: 0.78rem;
        font-family: inherit;
        color: var(--text-dark);
        background: #FAFAFA;
    }

    .alert-banner {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.86rem;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success { background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; }
    .alert-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Jadwal Acara</h1>
            <p class="page-sub">Validasi pengajuan jadwal reservasi, sesuaikan tanggal acara, dan kirim pengingat WhatsApp ke client.</p>
        </div>
        @if(($pendingReservationsCount ?? 0) > 0)
            <div class="badge-pending-count">
                <i class="fa-solid fa-clock"></i> {{ $pendingReservationsCount }} Menunggu Konfirmasi
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert-banner alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-banner alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="table-card">
        <table class="admin-jadwal-table">
            <thead>
                <tr>
                    <th style="width: 55px; text-align: center;">No</th>
                    <th>Kode &amp; Pemesan</th>
                    <th>Paket / Layanan</th>
                    <th>Tanggal &amp; Jam Acara</th>
                    <th>Status</th>
                    <th>Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $item)
                    @php
                        $rowId = $item->id_reservasi ?? $item->id;
                        $namaLayanan = $item->layanans->pluck('nama_layanan')->filter()->implode(', ');
                        $statusClass = match($item->status_reservasi) {
                            'Disetujui' => 'status-approved',
                            'Ditolak' => 'status-rejected',
                            default => 'status-pending',
                        };
                    @endphp
                    <tr @if($item->status_reservasi === 'Menunggu Konfirmasi') style="background-color: #FFFDF7;" @endif>
                        <td style="text-align: center; font-weight: 700; color: var(--text-muted);">
                            {{ $reservasi->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <strong>{{ $item->kode_reservasi ?? '#' . $rowId }}</strong><br>
                            <span>{{ $item->user->name ?? 'Client' }}</span><br>
                            <small style="color: var(--text-muted);">{{ $item->user->phone ?? $item->user->no_hp ?? '-' }}</small>
                        </td>
                        <td>
                            <strong>{{ $item->nama_paket ?: ($namaLayanan ?: ($item->nama_layanan ?: ($item->jenis_acara ?: '—'))) }}</strong>
                            @if($item->lokasi_acara ?? $item->lokasi)
                                <br><small style="color: var(--text-muted);">{{ $item->lokasi_acara ?? $item->lokasi }}</small>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <strong>{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}</strong><br>
                            <small style="color: var(--text-muted);">
                                {{ $item->waktu_mulai ? substr($item->waktu_mulai, 0, 5) : '08:00' }} – {{ $item->waktu_selesai ? substr($item->waktu_selesai, 0, 5) : '16:00' }}
                            </small>
                        </td>
                        <td>
                            <span class="status-pill {{ $statusClass }}">
                                {{ $item->status_reservasi }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                {{-- Tombol Validasi (Hanya muncul jika belum Disetujui) --}}
                                @if($item->status_reservasi !== 'Disetujui')
                                    <form action="{{ route('admin.jadwal.validasi', $rowId) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-admin btn-validate">
                                            <i class="fa-solid fa-check"></i> Validasi
                                        </button>
                                    </form>
                                @endif

                                {{-- Form Ubah Tanggal Acara --}}
                                <form action="{{ route('admin.jadwal.updateTanggal', $rowId) }}" method="POST" style="display: inline-flex; align-items: center; gap: 6px; margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <input type="date" name="tanggal_acara" class="date-input-inline" value="{{ \Carbon\Carbon::parse($item->tanggal_acara)->format('Y-m-d') }}" required>
                                    <button type="submit" class="btn-admin btn-date" title="Perbarui Tanggal Acara">
                                        <i class="fa-solid fa-calendar-day"></i> Ubah Tgl
                                    </button>
                                </form>

                                {{-- Tombol Kirim Pengingat WhatsApp --}}
                                <form action="{{ route('admin.jadwal.kirimWa', $rowId) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-admin btn-wa" title="Kirim Pengingat Jadwal via WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Belum ada data pengajuan jadwal acara.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $reservasi->links('vendor.pagination.client-custom') }}
    </div>
@endsection