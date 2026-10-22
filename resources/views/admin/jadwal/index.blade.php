@extends('layouts.admin')

@section('title', 'Jadwal Acara - Admin Griya Rias Elly Jr.')

@push('styles')
<style>
    .wrap { max-width: 100%; margin: 0 auto; }
    
    .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    
    .eyebrow { 
        color: var(--gold-primary); 
        text-transform: uppercase; 
        letter-spacing: .12em; 
        font-size: 11px; 
        font-weight: 700; 
    }

    h1 { 
        margin: 5px 0; 
        color: var(--text-dark); 
        font-family: 'Playfair Display', serif; 
        font-size: 28px; 
    }

    p { color: var(--text-muted); margin: 5px 0; font-size: 0.9rem; }

    /* Button Custom Styles */
    .btn { 
        border: 0; 
        border-radius: 8px; 
        padding: 10px 16px; 
        background: var(--gold-primary); 
        color: #fff; 
        cursor: pointer; 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 14px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        gap: 7px; 
        white-space: nowrap; 
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(197, 143, 67, 0.15);
    }
    .btn:hover { background: var(--gold-hover); }

    .btn-light { background: #fff; color: var(--text-dark); border: 1px solid var(--border-color); box-shadow: none; }
    .btn-light:hover { background: #f5eee7; }

    /* Layout Grid */
    .layout-grid { display: grid; grid-template-columns: 1fr 340px; gap: 24px; }

    /* Card List Jadwal */
    .jadwal-list { display: flex; flex-direction: column; gap: 16px; }
    .jadwal-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--gold-primary);
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .badge-date {
        background-color: var(--gold-primary);
        color: #FFF;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: inline-block;
        margin-bottom: 6px;
    }

    .client-name { font-weight: 700; font-size: 1rem; color: var(--text-dark); }
    .location-info { font-size: 0.82rem; color: var(--text-muted); margin-top: 2px; }

    .card-actions { display: flex; gap: 8px; }
    
    .btn-sm {
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.2s;
    }
    .btn-sm:hover { opacity: 0.88; }

    .btn-validasi { background-color: #4E9F70; color: #fff; }
    .btn-ubah { background-color: #3B82F6; color: #fff; }

    /* Panel WA Direct */
    .panel-wa {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        position: sticky;
        top: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .wa-title { font-size: 0.95rem; font-weight: 700; color: var(--gold-primary); display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .wa-desc { font-size: 0.78rem; color: var(--text-muted); line-height: 1.4; margin-bottom: 14px; }
    
    .wa-box {
        background-color: #FAFAFA;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px;
        font-size: 0.8rem;
        color: var(--text-dark);
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .btn-kirim-wa {
        width: 100%;
        background-color: #10B981;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-kirim-wa:hover { opacity: 0.9; }

    /* Modal Overlay & Card Custom */
    .modal-overlay { 
        position: fixed; inset: 0; 
        background: rgba(36, 26, 22, 0.6); 
        display: none; justify-content: center; align-items: center; 
        z-index: 9999; backdrop-filter: blur(4px); padding: 18px; 
    }
    .modal-overlay.show { display: flex; }
    
    .modal-card { 
        background-color: #fff; 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        width: 100%; max-width: 420px; padding: 24px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.15); 
    }
    .modal-card-calendar { max-width: 650px; padding: 28px; }

    /* Style Kalender Interaktif */
    .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .calendar-nav-btn { background: #f4eee6; border: 1px solid var(--border-color); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; color: var(--text-dark); }
    .calendar-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--gold-primary); margin: 0; }
    .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; text-align: center; }
    .calendar-weekday { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); padding-bottom: 8px; text-transform: uppercase; }
    .calendar-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; background: #faf6f0; border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); cursor: default; }
    .calendar-day.empty { background: transparent; }
    .calendar-day.booked {
        background-color: #EF4444 !important;
        color: #FFFFFF !important;
        font-weight: 700 !important;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
    }

    /* Memastikan SweetAlert2 Berada di Depan Modal */
    .swal2-container {
        z-index: 10000 !important;
    }

    @media(max-width: 992px) {
        .layout-grid { grid-template-columns: 1fr; }
        .panel-wa { position: relative; top: 0; }
    }
</style>
@endpush

@section('content')
<div class="wrap">
    <header class="top">
        <div>
            <span class="eyebrow">Administrasi</span>
            <h1>Jadwal Acara Terdaftar</h1>
            <p>Atur ketersediaan tanggal, validasi pesanan, dan kirim pengingat acara.</p>
        </div>
        <div>
            <button class="btn" type="button" onclick="openModalCalendar()">
                <i class="fa-regular fa-calendar-days"></i> Lihat Kalender
            </button>
        </div>
    </header>

    <div class="layout-grid">
        <!-- Kolom Kiri: Daftar Jadwal Acara -->
        <div>
            <div class="jadwal-list">
                @forelse($reservasi as $item)
                    <div class="jadwal-card">
                        <div>
                            <span class="badge-date">
                                {{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }} • {{ strtoupper($item->jenis_acara ?? 'FULL DAY') }}
                            </span>
                            <div class="client-name">{{ $item->user->name ?? 'Pelanggan' }} ({{ $item->detail_acara ?? 'Rias Pengantin' }})</div>
                            <div class="location-info">Lokasi: {{ $item->lokasi ?? 'Lokasi Klien' }}</div>
                        </div>

                        <div class="card-actions">
                            <!-- Tombol WA Direct -->
                            <button class="btn-sm" style="background:#10B981; color:#fff;" 
                                onclick="pilihPelangganWA('{{ $item->user->name ?? 'Pelanggan' }}', '{{ $item->user->no_hp ?? '' }}', '{{ \Carbon\Carbon::parse($item->tanggal_acara)->translatedFormat('d F Y') }}')">
                                <i class="fa-brands fa-whatsapp"></i> WA
                            </button>

                            <!-- Tombol Validasi / Tervalidasi -->
                            @php
                                $isTervalidasi = ($item->status_reservasi == 'Disetujui') || ($item->jadwal &&$item->jadwal->status_validasi == 'Tervalidasi');
                            @endphp

                            @if($isTervalidasi)
                                <button class="btn-sm btn-validasi" style="background-color: #6B7280; cursor: not-allowed; opacity: 0.7;" disabled>
                                    <i class="fa-solid fa-check-double"></i> Tervalidasi
                                </button>
                            @else
                                <form action="{{ route('admin.jadwal.validasi', $item->id_reservasi) }}" method="POST" style="margin: 0;" onsubmit="confirmValidasi(event, this)">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-validasi">
                                        <i class="fa-solid fa-check"></i> Validasi
                                    </button>
                                </form>
                            @endif

                            <button class="btn-sm btn-ubah" onclick="openModalUbah({{ $item->id_reservasi }}, '{{$item->tanggal_acara }}')">
                                <i class="fa-solid fa-calendar-pen"></i> Ubah Tanggal
                            </button>
                        </div>
                    </div>
                @empty
                    <div style="background:#fff; border:1px solid var(--border-color); padding:40px; text-align:center; border-radius:12px; color:var(--text-muted);">
                        Belum ada jadwal acara terdaftar saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Kirim WhatsApp Direct -->
        <div>
            <div class="panel-wa">
                <div class="wa-title"><i class="fa-regular fa-comment-dots"></i> Kirim WhatsApp Direct</div>
                <p class="wa-desc">Pilih tombol WA pada salah satu jadwal pelanggan untuk memuat template pengingat otomatis.</p>

                <div class="wa-box" id="waPreviewBox">
                    Klik tombol WA pada pelanggan di sebelah kiri untuk menampilkan pesan otomatis di sini.
                </div>

                <a href="#" id="btnKirimWA" target="_blank" class="btn-kirim-wa">
                    <i class="fa-paper-plane"></i> KIRIM WA NOTIFIKASI
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Kalender -->
<div class="modal-overlay" id="modalCalendar" onclick="backdropClose(event, this)">
    <div class="modal-card modal-card-calendar">
        <div class="calendar-header">
            <button class="calendar-nav-btn" onclick="changeMonth(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <h3 class="calendar-title" id="calendarMonthTitle">Oktober 2026</h3>
            <button class="calendar-nav-btn" onclick="changeMonth(1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="calendar-grid">
            <div class="calendar-weekday">Min</div>
            <div class="calendar-weekday">Sen</div>
            <div class="calendar-weekday">Sel</div>
            <div class="calendar-weekday">Rab</div>
            <div class="calendar-weekday">Kam</div>
            <div class="calendar-weekday">Jum</div>
            <div class="calendar-weekday">Sab</div>
        </div>
        <div class="calendar-grid" id="calendarDaysGrid" style="margin-top: 8px;"></div>
        <div style="margin-top: 20px; text-align: right;">
            <button type="button" class="btn btn-light" onclick="closeModalCalendar()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Ubah Tanggal -->
<div class="modal-overlay" id="modalUbah" onclick="backdropClose(event, this)">
    <div class="modal-card">
        <h3 style="font-family:'Playfair Display', serif; margin-bottom:16px; color:var(--text-dark);">Ubah Tanggal Acara</h3>
        <form id="formUbahTanggal" method="POST" onsubmit="confirmUbahTanggal(event, this)">
            @csrf
            @method('PUT')
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:0.8rem; font-weight:700; margin-bottom:6px; color:var(--text-dark);">Tanggal Acara Baru</label>
                <input type="date" name="tanggal_acara" id="tanggal_acara" required style="width:100%; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit; outline:none;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" class="btn btn-light" style="flex:1;" onclick="closeModalUbah()">Batal</button>
                <button type="submit" class="btn" style="flex:1;">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let bookedDatesList = [];

    function backdropClose(e, el) { if(e.target === el) el.classList.remove('show'); }

    function openModalCalendar() {
        document.getElementById('modalCalendar').classList.add('show');
        fetch('{{ route("api.jadwal.tervalidasi") }}')
            .then(res => res.json())
            .then(data => {
                bookedDatesList = data;
                renderCalendar(currentMonth, currentYear);
            })
            .catch(err => console.error('Gagal mengambil jadwal tervalidasi:', err));
    }

    function closeModalCalendar() {
        document.getElementById('modalCalendar').classList.remove('show');
    }

    function changeMonth(direction) {
        currentMonth += direction;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        } else if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    }

    function renderCalendar(month, year) {
        const grid = document.getElementById('calendarDaysGrid');
        const title = document.getElementById('calendarMonthTitle');
        grid.innerHTML = '';

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        title.textContent = `${monthNames[month]} ${year}`;

        const firstDayIndex = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDayIndex; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day empty';
            grid.appendChild(emptyCell);
        }

        for (let day = 1; day <= totalDays; day++) {
            const dayCell = document.createElement('div');
            dayCell.className = 'calendar-day';
            dayCell.textContent = day;

            const formattedMonth = String(month + 1).padStart(2, '0');
            const formattedDay = String(day).padStart(2, '0');
            const dateString = `${year}-${formattedMonth}-${formattedDay}`;

            if (bookedDatesList.includes(dateString)) {
                dayCell.classList.add('booked');
                dayCell.title = "Tanggal Sudah Dibooking / Tervalidasi";
            }

            grid.appendChild(dayCell);
        }
    }

    function openModalUbah(id, tanggal) {
        const form = document.getElementById('formUbahTanggal');
        form.action = `/admin/jadwal/update-tanggal/${id}`;
        document.getElementById('tanggal_acara').value = tanggal;
        document.getElementById('modalUbah').classList.add('show');
    }

    function closeModalUbah() {
        document.getElementById('modalUbah').classList.remove('show');
    }

    function pilihPelangganWA(nama, noHp, tanggal) {
        let formattedPhone = noHp.replace(/^0/, '62');
        let pesan = `Halo Kak ${nama}, ini pengingat dari Griya Rias Elly Jr. mengenai jadwal acara Anda pada tanggal ${tanggal}. Perias kami akan tiba di lokasi sesuai jadwal. Terima kasih!`;
        
        document.getElementById('waPreviewBox').innerText = pesan;
        
        let waLink = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(pesan)}`;
        document.getElementById('btnKirimWA').setAttribute('href', waLink);
    }

    // ================= SWEETALERT2 CONFIRMATIONS =================

    function confirmValidasi(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Validasi Jadwal Acara?',
            text: "Tanggal acara ini akan otomatis ditandai terbooking pada kalender.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4E9F70',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Validasi!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmUbahTanggal(event, form) {
        event.preventDefault();
        closeModalUbah();

        Swal.fire({
            title: 'Simpan Perubahan Tanggal?',
            text: "Jadwal acara pelanggan akan diperbarui ke tanggal baru.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Perbarui!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                document.getElementById('modalUbah').classList.add('show');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#C58F43',
                background: '#FFFFFF',
                color: '#241A16'
            });
        @endif
    });
</script>
@endpush