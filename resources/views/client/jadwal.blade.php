@extends('layouts.client')

@section('title', 'Jadwal Acara & Ketersediaan - Griya Rias Elly Jr.')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<style>
    :root {
        --success-green: #2E7D32;
        --danger-red: #DC2626;
    }

    .page-header { margin-bottom: 24px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--text-dark); margin-bottom: 6px; }
    .page-sub { color: var(--text-muted); font-size: 0.9rem; }

    /* Calendar Card Container */
    .calendar-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    
    /* Legend Keterangan Warna */
    .legend-box { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .dot { width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; }
    .dot-green { background-color: var(--success-green); }
    .dot-red { background-color: var(--danger-red); }
    .availability-dot { width: 7px; height: 7px; background: #22C55E; border-radius: 50%; display: inline-block; margin: 5px 0 0 5px; box-shadow: 0 0 0 3px rgba(34,197,94,.14); vertical-align: top; }

    /* FullCalendar Custom Styling */
    #calendar { max-width: 100%; margin: 0 auto; }
    .fc-event { cursor: pointer; border-radius: 6px; padding: 4px; font-weight: 600; }
    .schedule-modal[hidden] { display: none; }
    .schedule-modal { position: fixed; inset: 0; z-index: 1000; display: grid; place-items: center; padding: 20px; background: rgba(36,26,22,.42); backdrop-filter: blur(6px); }
    .schedule-modal-card { width: min(500px, 100%); max-height: min(80vh, 620px); overflow-y: auto; background: #fff; border-radius: 22px; padding: 26px; box-shadow: 0 24px 70px rgba(36,26,22,.26); animation: schedule-modal-in .2s ease-out; }
    @keyframes schedule-modal-in { from { opacity: 0; transform: translateY(12px) scale(.98); } to { opacity: 1; transform: none; } }
    .schedule-modal-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); }
    .schedule-modal-head h2 { font-family: 'Playfair Display', serif; font-size: 1.35rem; }
    .schedule-modal-close { width: 34px; height: 34px; border: 1px solid var(--border-color); background: #fff; border-radius: 50%; cursor: pointer; color: var(--text-muted); }
    .schedule-modal-close:hover { color: var(--gold-hover); border-color: var(--gold-primary); }
    .schedule-time-list { display: grid; gap: 10px; margin-top: 18px; }
    .schedule-time-item { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 11px; font-size: .84rem; }
    .schedule-time-item.busy { background: #FEF2F2; color: #991B1B; }
    .schedule-time-item.free { background: #F0FDF4; color: #166534; }
    .schedule-time-dot { width: 9px; height: 9px; border-radius: 50%; flex: 0 0 9px; }
    .schedule-time-item.busy .schedule-time-dot { background: #DC2626; }
    .schedule-time-item.free .schedule-time-dot { background: #22C55E; box-shadow: 0 0 0 3px rgba(34,197,94,.15); }
    .schedule-modal-note { color: var(--text-muted); font-size: .75rem; line-height: 1.5; margin-top: 16px; }
    
    .btn-reservasi-cta {
        display: inline-block;
        margin-top: 24px;
        background-color: var(--gold-primary);
        color: #fff;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2);
    }
    .btn-reservasi-cta:hover { background-color: var(--gold-hover); }
</style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Kalender Ketersediaan Jadwal</h1>
        <p class="page-sub">Cek tanggal acara yang tersedia sebelum melakukan pemesanan jadwal.</p>
    </div>

    <div class="calendar-card">
        <div class="legend-box">
            <div class="legend-item">
                <span class="dot dot-green"></span> Hijau: jam masih tersedia
            </div>
            <div class="legend-item">
                <span class="dot dot-red"></span> Merah: full day; keterangan jam: booking sebagian
            </div>
        </div>

        <div id="calendar"></div>

        <div style="text-align: right;">
            <a href="{{ route('reservasi.create') }}" class="btn-reservasi-cta">
                <i class="fa-solid fa-calendar-plus"></i> Lanjut Buat Reservasi
            </a>
        </div>
    </div>

    <div class="schedule-modal" id="schedule-modal" hidden>
        <div class="schedule-modal-card" role="dialog" aria-modal="true" aria-labelledby="schedule-modal-title">
            <div class="schedule-modal-head">
                <div><h2 id="schedule-modal-title">Detail Jadwal</h2><small id="schedule-modal-date" style="color:var(--text-muted);"></small></div>
                <button type="button" class="schedule-modal-close" id="schedule-modal-close" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="schedule-time-list" id="schedule-time-list"></div>
            <p class="schedule-modal-note">Titik hijau menunjukkan rentang waktu yang masih kosong dan dapat dipilih saat membuat reservasi.</p>
        </div>
    </div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            displayEventTime: false,
            dateClick: function(info) {
                showScheduleDetail(info.dateStr);
            },
            events: '{{ route("client.jadwal.json") }}',
            dayCellDidMount: function(info) {
                info.el.style.backgroundColor = '#F4FAF6'; 
                const dot = document.createElement('span');
                dot.className = 'availability-dot';
                dot.title = 'Masih ada jam yang dapat dibooking';
                const dayNumber = info.el.querySelector('.fc-daygrid-day-number');
                if (dayNumber) dayNumber.after(dot);
            },
            eventDidMount: function(info) {
                if (info.event.extendedProps.fullDay) {
                    let dateStr = info.event.startStr.split('T')[0];
                    let cellEl = document.querySelector(`.fc-daygrid-day[data-date="${dateStr}"]`);
                    if (cellEl) {
                        cellEl.style.backgroundColor = '#FEE2E2';
                        if (info.event.extendedProps.fullDay) cellEl.querySelector('.availability-dot')?.remove();
                    }
                }
            }
        });
        calendar.render();

        function formatDate(dateString) {
            return new Intl.DateTimeFormat('id-ID', { dateStyle: 'full' }).format(new Date(dateString + 'T00:00:00'));
        }

        function showScheduleDetail(dateString) {
            const events = calendar.getEvents().filter(event => event.startStr.split('T')[0] === dateString);
            const ranges = events.map(event => ({
                start: event.allDay ? 0 : event.start.getHours() * 60 + event.start.getMinutes(),
                end: event.allDay ? 1440 : (event.end ? event.end.getHours() * 60 + event.end.getMinutes() : 1440),
                busy: true,
            })).sort((a, b) => a.start - b.start);
            const slots = [];
            let cursor = 0;
            ranges.forEach(range => {
                if (range.start > cursor) slots.push({ start: cursor, end: range.start, busy: false });
                slots.push(range);
                cursor = Math.max(cursor, range.end);
            });
            if (cursor < 1440) slots.push({ start: cursor, end: 1439, busy: false });

            const minutesToTime = minutes => String(Math.floor(minutes / 60)).padStart(2, '0') + ':' + String(minutes % 60).padStart(2, '0');
            document.getElementById('schedule-modal-title').textContent = events.length ? 'Detail Booking' : 'Jadwal Tersedia';
            document.getElementById('schedule-modal-date').textContent = formatDate(dateString);
            document.getElementById('schedule-time-list').innerHTML = slots.length
                ? slots.map(slot => `<div class="schedule-time-item ${slot.busy ? 'busy' : 'free'}"><span class="schedule-time-dot"></span><strong>${slot.busy ? 'Sudah dibooking' : 'Masih tersedia'}</strong><span>${minutesToTime(slot.start)} – ${minutesToTime(slot.end)}</span></div>`).join('')
                : '<div class="schedule-time-item busy"><span class="schedule-time-dot"></span><strong>Full day sudah dibooking</strong></div>';
            document.getElementById('schedule-modal').hidden = false;
        }

        document.getElementById('schedule-modal-close').addEventListener('click', () => document.getElementById('schedule-modal').hidden = true);
        document.getElementById('schedule-modal').addEventListener('click', event => {
            if (event.target.id === 'schedule-modal') event.target.hidden = true;
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') document.getElementById('schedule-modal').hidden = true;
        });
    });
</script>
@endpush