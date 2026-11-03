@extends('layouts.admin')

@section('title', 'Kelola Kategori Paket - Admin Griya Rias Elly Jr.')

@push('styles')
<style>
    .wrap { max-width: 100%; margin: 0 auto; }
    
    .top, .toolbar, .actions { display: flex; align-items: center; gap: 12px; }
    .top, .toolbar { justify-content: space-between; }
    .top { margin-bottom: 24px; }
    
    .eyebrow { 
        color: var(--gold-primary); 
        text-transform: uppercase; 
        letter-spacing: .15em; 
        font-size: 11px; 
        font-weight: 800; 
    }

    h1 { 
        margin: 4px 0; 
        color: var(--text-dark); 
        font-family: 'Playfair Display', serif; 
        font-size: 28px; 
        font-weight: 700;
    }

    p { color: var(--text-muted); margin: 4px 0; font-size: 0.9rem; font-weight: 500; }

    /* Button Custom Styles Tajam */
    .btn { 
        border: 1px solid #A06F2D; 
        border-radius: 8px; 
        padding: 10px 18px; 
        background: var(--gold-primary); 
        color: #fff; 
        cursor: pointer; 
        text-decoration: none; 
        font-weight: 700; 
        font-size: 14px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        gap: 8px; 
        white-space: nowrap; 
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2);
    }
    .btn:hover { background: var(--gold-hover); border-color: #835B25; transform: translateY(-1px); }

    .btn-light { 
        background: #fff; 
        color: var(--text-dark); 
        border: 1px solid #D8CEC0; 
        box-shadow: 0 2px 6px rgba(0,0,0,0.02); 
    }
    .btn-light:hover { background: #FBF5EC; border-color: var(--gold-primary); color: var(--gold-hover); }

    /* Panel Table Styling Bergaris Tegas */
    .panel { 
        background: var(--bg-card); 
        border: 1px solid #D8CEC0; 
        border-radius: 12px; 
        box-shadow: 0 4px 14px rgba(36, 26, 22, 0.03); 
        overflow: hidden; 
    }

    .toolbar { padding: 18px 20px; border-bottom: 1px solid var(--border-color); background: #FAF9F6; }
    .toolbar h2 { margin: 0; font-size: 18px; color: var(--text-dark); font-family: 'Playfair Display', serif; font-weight: 700; }

    .table-wrap { overflow: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 650px; }
    
    th { 
        text-align: left; 
        color: var(--gold-primary); 
        background: #FAFAFA; 
        padding: 14px 16px; 
        font-size: 11px; 
        letter-spacing: .08em; 
        text-transform: uppercase; 
        font-weight: 800;
        border-bottom: 2px solid var(--border-color); 
    }

    td { padding: 15px 16px; border-top: 1px solid var(--border-color); vertical-align: middle; font-size: 0.9rem; }
    tbody tr:hover { background: #FDFBF7; }

    .subtle { color: var(--text-muted); font-size: 13px; font-weight: 500; }

    .count { 
        display: inline-flex; 
        align-items: center;
        gap: 6px;
        padding: 5px 12px; 
        border-radius: 20px; 
        background: #FBF5EC; 
        color: #835B25; 
        font-size: 12px; 
        font-weight: 700; 
        border: 1px solid #EAD8BF;
    }

    .row-actions { display: flex; gap: 8px; }
    .icon-btn { 
        border: none; 
        border-radius: 6px; 
        padding: 7px 12px; 
        cursor: pointer; 
        font-weight: 700; 
        font-size: 0.8rem; 
        color: #fff; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        transition: all 0.2s ease;
    }
    .icon-btn:hover:not(:disabled) { opacity: 0.9; transform: translateY(-1px); }
    .icon-btn.btn-edit { background: #2563EB; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2); }
    .icon-btn.btn-danger { background: #DC2626; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2); }
    .icon-btn:disabled { opacity: .45; cursor: not-allowed; box-shadow: none; }

    .empty { text-align: center; color: var(--text-muted); padding: 36px; font-weight: 600; }

    /* Modal Custom Styles Tajam */
    .modal-backdrop { 
        position: fixed; inset: 0; 
        background: rgba(24, 18, 15, 0.65); 
        display: none; align-items: center; justify-content: center; 
        padding: 18px; z-index: 9999; backdrop-filter: blur(4px);
    }
    .modal-backdrop.show { display: flex; }

    .modal { 
        width: min(480px, 100%); 
        background: #fff; border-radius: 12px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.2); border: 1px solid #D8CEC0;
    }

    .modal-head, .modal-foot { 
        padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; 
        border-bottom: 1px solid var(--border-color); background: #FAF9F6;
    }
    .modal-foot { border: 0; border-top: 1px solid var(--border-color); justify-content: flex-end; gap: 10px; background: #FFF; }
    
    .modal-head h2 { margin: 0; color: var(--text-dark); font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; }
    .close { border: 0; background: transparent; font-size: 24px; color: var(--text-muted); cursor: pointer; font-weight: 700; }
    .close:hover { color: #DC2626; }

    .modal-body { padding: 24px; }
    .field label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 700; color: var(--text-dark); }
    .field input { 
        width: 100%; font-family: inherit; color: var(--text-dark); 
        padding: 10px 14px; border: 1px solid #D8CEC0; 
        border-radius: 8px; outline: none; background: #FAFAFA;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .field input:focus { border-color: var(--gold-primary); background: #FFF; box-shadow: 0 0 0 3px rgba(197, 143, 67, 0.15); }
    .hint { font-size: 12px; color: var(--text-muted); margin-top: 8px; font-weight: 500; }

    .swal2-container {
        z-index: 10000 !important;
    }

    @media(max-width:680px){
        .top { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="wrap">
    <header class="top">
        <div>
            <span class="eyebrow">Administrasi</span>
            <h1>Kategori Paket</h1>
            <p>Kelola kategori yang digunakan pada data paket.</p>
        </div>
        <div class="actions">
            <a class="btn btn-light" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button class="btn" type="button" onclick="openModal('create-modal')"><i class="fa-solid fa-plus"></i> Tambah Kategori</button>
        </div>
    </header>

    <section class="panel">
        <div class="toolbar">
            <h2>Daftar Kategori <span class="subtle">({{ $kategoriPakets->count() }})</span></h2>
        </div>
        
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Paket Terhubung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriPakets as $kategori)
                    <tr>
                        <td>
                            <strong>{{ $kategori->nama_kategori }}</strong>
                            <div class="subtle">Kategori #{{ $kategori->id }}</div>
                        </td>
                        <td>
                            <span class="count"><i class="fa-solid fa-box-open" style="font-size:11px;"></i> {{ $kategori->pakets_count }} paket</span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <button class="icon-btn btn-edit" type="button" onclick="editKategori(this)" 
                                        data-action="{{ route('admin.kategori-paket.update',$kategori) }}" 
                                        data-name="{{ $kategori->nama_kategori }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <form method="POST" action="{{ route('admin.kategori-paket.destroy',$kategori) }}" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="icon-btn btn-danger" type="submit" 
                                            @disabled($kategori->pakets_count > 0) 
                                            title="{{ $kategori->pakets_count > 0 ? 'Kategori masih dipakai paket' : 'Hapus kategori' }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="empty" colspan="3">Belum ada kategori. Klik “Tambah Kategori” untuk mulai mengisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal-backdrop" id="create-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="create-form" method="POST" action="{{ route('admin.kategori-paket.store') }}" onsubmit="confirmCreate(event, this)">
            @csrf
            <div class="modal-head">
                <h2>Tambah Kategori Baru</h2>
                <button class="close" type="button" onclick="closeModal('create-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label>Nama Kategori</label>
                    <input name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Paket Pernikahan" required maxlength="100">
                    <div class="hint">Nama kategori harus unik.</div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn btn-light" type="button" onclick="closeModal('create-modal')">Batal</button>
                <button class="btn" type="submit">Simpan Kategori</button>
            </div>
        </form>
    </section>
</div>

<!-- Modal Edit Kategori -->
<div class="modal-backdrop" id="edit-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="edit-form" method="POST" onsubmit="confirmUpdate(event, this)">
            @csrf 
            @method('PUT')
            <div class="modal-head">
                <h2>Ubah Kategori</h2>
                <button class="close" type="button" onclick="closeModal('edit-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label>Nama Kategori</label>
                    <input id="edit-name" name="nama_kategori" required maxlength="100">
                    <div class="hint">Perubahan nama berlaku pada semua paket yang terhubung.</div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openModal(id){ document.getElementById(id).classList.add('show'); }
    function closeModal(id){ document.getElementById(id).classList.remove('show'); }
    function backdropClose(e,el){ if(e.target===el) el.classList.remove('show'); }

    function editKategori(b){
        document.getElementById('edit-form').action = b.dataset.action;
        document.getElementById('edit-name').value = b.dataset.name;
        openModal('edit-modal');
    }

    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => m.classList.remove('show'));
    });

    function confirmCreate(event, form) {
        event.preventDefault();
        closeModal('create-modal');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Simpan Kategori Baru?',
                text: "Pastikan nama kategori yang dimasukkan sudah sesuai.",
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
                } else {
                    openModal('create-modal');
                }
            });
        } else {
            form.submit();
        }
    }

    function confirmUpdate(event, form) {
        event.preventDefault();
        closeModal('edit-modal');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Nama kategori akan diperbarui di seluruh paket yang terhubung.",
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
                    openModal('edit-modal');
                }
            });
        } else {
            form.submit();
        }
    }

    function confirmDelete(event, form) {
        event.preventDefault();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Kategori Ini?',
                text: "Kategori ini akan dihapus permanen dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    // Do nothing
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                form.submit();
            }
        }
    }
</script>
@endpush