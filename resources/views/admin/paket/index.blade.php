@extends('layouts.admin')

@section('title', 'Kelola Paket - Admin Griya Rias Elly Jr.')

@push('styles')
<style>
    .wrap { max-width: 100%; margin: 0 auto; }
    
    .top, .toolbar, .actions { display: flex; align-items: center; gap: 12px; }
    .top, .toolbar { justify-content: space-between; }
    .top { margin-bottom: 24px; }
    
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

    /* Panel Table Styling */
    .panel { 
        background: var(--bg-card); 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.02); 
        overflow: hidden; 
    }

    .toolbar { padding: 18px 20px; border-bottom: 1px solid var(--border-color); }
    .toolbar h2 { margin: 0; font-size: 17px; color: var(--text-dark); font-family: 'Playfair Display', serif; }
    
    .search { display: flex; gap: 8px; }
    .control, .field input, .field textarea, .field select, .search input { 
        font-family: inherit; 
        color: var(--text-dark); 
        padding: 10px 12px; 
        border: 1px solid var(--border-color); 
        border-radius: 8px; 
        background: #FAFAFA; 
        outline: none; 
    }
    
    .search input { width: 285px; }
    .control:focus, .field input:focus, .field textarea:focus, .field select:focus, .search input:focus { 
        border-color: var(--gold-primary); 
        background: #fff;
    }

    input, textarea, select { width: 100%; }
    
    .table-wrap { overflow: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 1000px; }
    
    th { 
        text-align: left; 
        color: var(--gold-primary); 
        background: #FAFAFA; 
        padding: 13px 16px; 
        font-size: 11px; 
        letter-spacing: .08em; 
        text-transform: uppercase; 
        border-bottom: 2px solid var(--border-color); 
    }

    td { padding: 15px 16px; border-top: 1px solid var(--border-color); vertical-align: middle; font-size: 0.9rem; }
    tbody tr:hover { background: #FDFBF9; }

    .subtle { color: var(--text-muted); font-size: 13px; }

    .status { display: inline-flex; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
    .status.active { color: #267145; background: #eaf6ee; border: 1px solid #c8e6c9; }
    .status.inactive { color: #75685f; background: #f0eeeb; border: 1px solid #e0dad5; }

    .row-actions { display: flex; gap: 8px; }
    .icon-btn { 
        border: none; 
        border-radius: 6px; 
        padding: 6px 12px; 
        cursor: pointer; 
        font-weight: 600; 
        font-size: 0.8rem; 
        color: #fff; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        transition: opacity 0.2s;
    }
    .icon-btn:hover { opacity: 0.88; }
    .icon-btn.btn-edit { background: #3B82F6; }
    .icon-btn.btn-danger { background: #EF4444; }

    .empty { text-align: center; color: var(--text-muted); padding: 36px; }

    /* Modal Custom Styles */
    .modal-backdrop { 
        position: fixed; inset: 0; 
        background: rgba(36, 26, 22, 0.6); 
        display: none; align-items: center; justify-content: center; 
        padding: 18px; z-index: 9999; backdrop-filter: blur(4px);
    }
    .modal-backdrop.show { display: flex; }

    .modal { 
        width: min(650px, 100%); max-height: 90vh; overflow: auto; 
        background: #fff; border-radius: 12px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.15); border: 1px solid var(--border-color);
    }

    .modal-head, .modal-foot { 
        padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; 
        border-bottom: 1px solid var(--border-color); 
    }
    .modal-foot { border: 0; border-top: 1px solid var(--border-color); justify-content: flex-end; gap: 10px; }
    
    .modal-head h2 { margin: 0; color: var(--text-dark); font-family: 'Playfair Display', serif; font-size: 19px; }
    .close { border: 0; background: transparent; font-size: 24px; color: var(--text-muted); cursor: pointer; }

    .modal-body { padding: 22px; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    
    .field label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 700; color: var(--text-dark); }
    .field.full { grid-column: 1/-1; }
    .field textarea { resize: vertical; }

    .featured-choice { display: flex; gap: 18px; align-items: center; margin-top: 8px; }
    .featured-choice label { display: flex; align-items: center; gap: 7px; margin: 0; color: var(--text-dark); font-weight: 500; }
    .field small { display: block; margin-top: 6px; color: var(--text-muted); font-size: 12px; }
    
    .notice { padding: 12px; border-radius: 8px; background: #FBF5EB; color: #79562D; margin-top: 14px; font-size: 13px; border: 1px solid #EFE8DE; }

    @media(max-width:760px){
        .top, .toolbar { align-items: flex-start; flex-direction: column; }
        .search, .search input { width: 100%; }
        .grid { grid-template-columns: 1fr; }
        .field.full { grid-column: auto; }
    }
</style>
@endpush

@section('content')
<div class="wrap">
    <header class="top">
        <div>
            <span class="eyebrow">Administrasi</span>
            <h1>Kelola Paket</h1>
            <p>Atur daftar paket, kategori, dan harga layanan.</p>
        </div>
        <div class="actions">
            <a class="btn btn-light" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <a class="btn btn-light" href="{{ route('admin.kategori-paket.index') }}"><i class="fa-solid fa-tags"></i> Kelola Kategori</a>
            <a class="btn btn-light" href="{{ route('admin.layanan.index') }}"><i class="fa-solid fa-scissors"></i> Kelola Layanan</a>
            <button class="btn" type="button" onclick="openModal('create-modal')"><i class="fa-solid fa-plus"></i> Tambah Paket</button>
        </div>
    </header>

    <section class="panel">
        <div class="toolbar">
            <h2>Daftar Paket <span class="subtle">({{ $pakets->count() }})</span></h2>
            <form class="search" method="GET">
                <input class="control" name="search" value="{{ $search }}" placeholder="Cari nama atau kategori...">
                <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                @if($search)
                    <a class="btn btn-light" href="{{ route('admin.paket.index') }}">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Unggulan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                    <tr>
                        <td>
                            @if($paket->foto)
                                <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" style="width:58px;height:48px;object-fit:cover;border-radius:8px">
                            @else
                                <span class="subtle">—</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $paket->nama_paket }}</strong>
                            <div class="subtle">ID #{{ $paket->id }}</div>
                        </td>
                        <td>{{ $paket->kategoriPaket?->nama_kategori ?? '—' }}</td>
                        <td><strong>Rp {{ number_format($paket->harga,0,',','.') }}</strong></td>
                        <td>
                            <span class="status {{ $paket->status === 'Aktif' ? 'active' : 'inactive' }}">{{ $paket->status }}</span>
                        </td>
                        <td>
                            @if($paket->unggulan)
                                <span class="status active">Unggulan</span>
                            @else
                                <span class="subtle">Tidak</span>
                            @endif
                        </td>
                        <td class="subtle">{{ \Illuminate\Support\Str::limit($paket->deskripsi ?: '—', 70) }}</td>
                        <td>
                            <div class="row-actions">
                                <button class="icon-btn btn-edit" type="button" onclick="editPaket(this)" 
                                        data-action="{{ route('admin.paket.update',$paket->id) }}" 
                                        data-name="{{ $paket->nama_paket }}" 
                                        data-category="{{ $paket->kategori_paket_id }}" 
                                        data-price="{{ $paket->harga }}" 
                                        data-status="{{ $paket->status }}" 
                                        data-featured="{{ $paket->unggulan ? 1 : 0 }}" 
                                        data-photo="{{ $paket->foto ? asset('storage/' . $paket->foto) : '' }}" 
                                        data-description="{{ $paket->deskripsi }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <form method="POST" action="{{ route('admin.paket.destroy',$paket->id) }}" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="icon-btn btn-danger" type="submit">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="empty" colspan="8">Belum ada paket. Klik “Tambah Paket” untuk mulai mengisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Modal Tambah Paket -->
<div class="modal-backdrop" id="create-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="create-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.paket.store') }}" onsubmit="confirmCreate(event, this)">
            @csrf
            <div class="modal-head">
                <h2>Tambah Paket Baru</h2>
                <button class="close" type="button" onclick="closeModal('create-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="grid">
                    <div class="field">
                        <label>Nama Paket</label>
                        <input name="nama_paket" value="{{ old('nama_paket') }}" placeholder="Contoh: Paket Rias Wisuda" required>
                    </div>
                    <div class="field">
                        <label>Kategori</label>
                        <select name="kategori_paket_id" required>
                            <option value="">Pilih kategori</option>
                            @foreach($kategoriPakets as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_paket_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Harga (Rp)</label>
                        <input type="text" inputmode="numeric" data-price-format name="harga" value="{{ old('harga') }}" placeholder="Contoh: 1.450.000" required>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Aktif" @selected(old('status','Aktif')==='Aktif')>Aktif</option>
                            <option value="Nonaktif" @selected(old('status')==='Nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="field full">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="3" placeholder="Tuliskan rincian fasilitas paket...">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="field full">
                        <label>Foto Paket</label>
                        <input type="file" name="foto" accept="image/jpeg,image/png,image/webp">
                        <small>Format JPG, PNG, atau WEBP. Maksimal 4 MB.</small>
                    </div>
                    <div class="field full">
                        <label>Tampilkan sebagai Unggulan?</label>
                        <div class="featured-choice">
                            <label><input style="width:auto" type="radio" name="unggulan" value="1" @checked(old('unggulan','0')==='1') required> Unggulan</label>
                            <label><input style="width:auto" type="radio" name="unggulan" value="0" @checked(old('unggulan','0')==='0') required> Tidak</label>
                        </div>
                    </div>
                </div>
                @if($kategoriPakets->isEmpty())
                    <div class="notice"><i class="fa-solid fa-circle-info"></i> Tambahkan kategori paket terlebih dahulu sebelum membuat paket.</div>
                @endif
            </div>
            <div class="modal-foot">
                <button class="btn btn-light" type="button" onclick="closeModal('create-modal')">Batal</button>
                <button class="btn" type="submit" @disabled($kategoriPakets->isEmpty())>Simpan Paket</button>
            </div>
        </form>
    </section>
</div>

<!-- Modal Edit Paket -->
<div class="modal-backdrop" id="edit-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="edit-form" method="POST" enctype="multipart/form-data" onsubmit="confirmUpdate(event, this)">
            @csrf 
            @method('PUT')
            <div class="modal-head">
                <h2>Ubah Paket</h2>
                <button class="close" type="button" onclick="closeModal('edit-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="grid">
                    <div class="field">
                        <label>Nama Paket</label>
                        <input id="edit-name" name="nama_paket" required>
                    </div>
                    <div class="field">
                        <label>Kategori</label>
                        <select id="edit-category" name="kategori_paket_id" required>
                            @foreach($kategoriPakets as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Harga (Rp)</label>
                        <input id="edit-price" type="text" inputmode="numeric" data-price-format name="harga" placeholder="Contoh: 1.450.000" required>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select id="edit-status" name="status">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="field full">
                        <label>Deskripsi</label>
                        <textarea id="edit-description" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="field full">
                        <label>Foto Paket</label>
                        <img id="edit-photo-preview" alt="Foto paket saat ini" style="display:none;max-width:150px;max-height:100px;object-fit:cover;border-radius:8px;margin-bottom:8px">
                        <input type="file" name="foto" accept="image/jpeg,image/png,image/webp">
                        <small>Kosongkan jika tidak ingin mengganti foto. Maksimal 4 MB.</small>
                    </div>
                    <div class="field full">
                        <label>Tampilkan sebagai Unggulan?</label>
                        <div class="featured-choice">
                            <label><input style="width:auto" type="radio" name="unggulan" value="1" required> Unggulan</label>
                            <label><input style="width:auto" type="radio" name="unggulan" value="0" required> Tidak</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn btn-light" type="button" onclick="closeModal('edit-modal')">Batal</button>
                <button class="btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Format Angka Rupiah Real-time
    function formatHarga(value){
        const digits = String(value ?? '').replace(/\D/g, '');
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.querySelectorAll('[data-price-format]').forEach(input => {
        input.value = formatHarga(input.value);
        input.addEventListener('input', () => {
            input.value = formatHarga(input.value);
        });
    });

    function openModal(id){ document.getElementById(id).classList.add('show'); }
    function closeModal(id){ document.getElementById(id).classList.remove('show'); }
    function backdropClose(e,el){ if(e.target===el) el.classList.remove('show'); }

    function editPaket(button){
        const d = button.dataset;
        const f = document.getElementById('edit-form');
        f.action = d.action;
        document.getElementById('edit-name').value = d.name;
        document.getElementById('edit-category').value = d.category;
        document.getElementById('edit-price').value = formatHarga(d.price);
        document.getElementById('edit-status').value = d.status;
        document.getElementById('edit-description').value = d.description;
        
        document.querySelector('#edit-form input[name="unggulan"][value="'+d.featured+'"]').checked = true;
        
        const preview = document.getElementById('edit-photo-preview');
        preview.src = d.photo;
        preview.style.display = d.photo ? 'block' : 'none';
        
        openModal('edit-modal');
    }

    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => m.classList.remove('show'));
    });

    // ================= SWEETALERT2 CONFIRMATIONS =================

    function confirmCreate(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Simpan Paket Baru?',
            text: "Pastikan rincian data paket yang diinputkan sudah sesuai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmUpdate(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Data paket layanan akan diperbarui di sistem.",
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
            }
        });
    }

    function confirmDelete(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Paket Ini?',
            text: "Data paket yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush