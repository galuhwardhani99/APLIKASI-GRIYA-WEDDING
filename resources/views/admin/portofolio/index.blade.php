@extends('layouts.admin')

@section('title', 'Galeri Portofolio - Admin Griya Rias Elly Jr.')

@push('styles')
<!-- CSS Fancybox untuk Zoom In/Out -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    /* Mengunci scroll halaman utama/latar belakang saat modal aktif */
body.body-no-scroll {
    overflow: hidden !important;
}
    .wrap { max-width: 100%; margin: 0 auto; }

    .header-action { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 24px; 
    }

    .eyebrow { 
        color: var(--gold-primary); 
        text-transform: uppercase; 
        letter-spacing: .15em; 
        font-size: 11px; 
        font-weight: 800; 
    }

    .page-title { 
        font-family: 'Playfair Display', serif; 
        color: var(--text-dark); 
        font-size: 28px; 
        font-weight: 700;
        margin: 4px 0 0;
    }

    /* Custom Button Styles Tajam */
    .btn-gold { 
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
    .btn-gold:hover { background: var(--gold-hover); border-color: #835B25; transform: translateY(-1px); }

    /* Portfolio Cards Grid Tajam */
    .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .portfolio-card { 
        background: var(--bg-card); 
        border: 1px solid #D8CEC0; 
        border-radius: 12px; 
        overflow: hidden; 
        box-shadow: 0 4px 14px rgba(36, 26, 22, 0.03); 
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .portfolio-card:hover {
        border-color: var(--gold-primary);
        transform: translateY(-2px);
    }
    
    .portfolio-img-wrapper { position: relative; overflow: hidden; display: block; cursor: pointer; border-bottom: 1px solid #EFE8DE; }
    .portfolio-img { width: 100%; height: 320px; object-fit: cover; background-color: #FAFAFA; transition: transform 0.3s ease; display: block; }
    .portfolio-img-overlay { position: absolute; inset: 0; background: rgba(24, 18, 15, 0.45); display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 1.5rem; opacity: 0; transition: opacity 0.3s ease; }
    .portfolio-img-wrapper:hover .portfolio-img { transform: scale(1.04); }
    .portfolio-img-wrapper:hover .portfolio-img-overlay { opacity: 1; }

    .portfolio-body { padding: 18px 16px; }
    .portfolio-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; margin-bottom: 6px; color: var(--text-dark); line-height: 1.25; }
    .portfolio-cat { 
        font-size: 0.72rem; 
        color: var(--gold-primary); 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 0.08em; 
        margin-bottom: 8px; 
        display: inline-block;
        padding: 3px 8px;
        background: #FBF5EC;
        border: 1px solid #EAD8BF;
        border-radius: 4px;
    }
    .portfolio-desc { font-size: 0.86rem; color: var(--text-muted); font-weight: 500; line-height: 1.4; }
    .portfolio-actions { display: flex; gap: 8px; margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--border-color); }

    .btn-sm { 
        padding: 7px 12px; 
        border: none; 
        border-radius: 6px; 
        font-size: 0.8rem; 
        font-weight: 700; 
        cursor: pointer; 
        color: #fff; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        transition: all 0.2s ease; 
    }
    .btn-edit { background-color: #2563EB; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2); }
    .btn-delete { background-color: #DC2626; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2); }
    .btn-sm:hover { opacity: 0.9; transform: translateY(-1px); }

    /* FIX SCROLL MODAL PERMANEN */
    .modal-overlay { 
        position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; 
        background: rgba(24, 18, 15, 0.65); 
        display: none; justify-content: center; align-items: center; 
        z-index: 9999; backdrop-filter: blur(4px); padding: 20px; 
    }
    .modal-overlay.show { display: flex; }
    
    .modal-card { 
        background-color: var(--bg-card); 
        border: 1px solid #D8CEC0; 
        border-radius: 12px; 
        width: 100%; 
        max-width: 520px; 
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
        overflow: hidden;
    }

    .modal-card form {
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 85vh;
        min-height: 0;
        overflow: hidden;
    }
    
    .modal-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 16px 24px; 
        border-bottom: 1px solid var(--border-color); 
        background: #FAF9F6;
        flex-shrink: 0;
    }
    .modal-title { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--text-dark); font-weight: 700; margin: 0; }
    .close-btn { background: none; border: none; cursor: pointer; font-size: 1.3rem; color: var(--text-muted); font-weight: 700; }
    .close-btn:hover { color: #DC2626; }

    /* Area Isi Modal Scrollable */
    .modal-body { 
        padding: 24px; 
        overflow-y: auto !important; 
        flex: 1 1 auto;
        min-height: 0;
    }

    .modal-body::-webkit-scrollbar { width: 6px; }
    .modal-body::-webkit-scrollbar-track { background: #FAFAFA; }
    .modal-body::-webkit-scrollbar-thumb { background: #C58F43; border-radius: 4px; }
    .modal-body::-webkit-scrollbar-thumb:hover { background: #A87632; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 0.82rem; font-weight: 700; margin-bottom: 7px; color: var(--text-dark); }
    
    .form-group input[type="text"], 
    .form-group select, 
    .form-group textarea,
    .form-group input[type="file"] { 
        width: 100%; 
        padding: 10px 14px; 
        border: 1px solid #D8CEC0; 
        border-radius: 8px; 
        background-color: #FAFAFA; 
        font-family: inherit; 
        font-size: 0.9rem; 
        color: var(--text-dark); 
        outline: none; 
        transition: all 0.2s ease;
    }
    
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
        border-color: var(--gold-primary); 
        background-color: #FFF; 
        box-shadow: 0 0 0 3px rgba(197, 143, 67, 0.15);
    }
    
    /* Sticky Action Buttons at Bottom */
    .modal-actions { 
        display: flex; 
        gap: 12px; 
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        background: #FFF;
        flex-shrink: 0;
    }

    .btn-cancel { 
        flex: 1; 
        background: #FFF; 
        border: 1px solid #D8CEC0; 
        padding: 10px; 
        border-radius: 8px; 
        cursor: pointer; 
        font-weight: 700; 
        color: var(--text-dark); 
        transition: all 0.2s ease;
    }
    .btn-cancel:hover { background-color: #FBF5EC; border-color: var(--gold-primary); color: var(--gold-hover); }
    
    .btn-save { 
        flex: 1; 
        background: var(--gold-primary); 
        color: #fff; 
        border: 1px solid #A06F2D; 
        padding: 10px; 
        border-radius: 8px; 
        cursor: pointer; 
        font-weight: 700; 
        box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2);
        transition: all 0.2s ease;
    }
    .btn-save:hover { background-color: var(--gold-hover); border-color: #835B25; }

    .empty-card {
        grid-column: 1 / -1; 
        text-align: center; 
        color: var(--text-muted); 
        padding: 40px; 
        background: #fff; 
        border-radius: 12px; 
        border: 1px solid #D8CEC0;
        font-weight: 600;
    }

    .swal2-container {
        z-index: 10000 !important;
    }

    @media(max-width: 680px) {
        .header-action { flex-direction: column; align-items: flex-start; gap: 14px; }
    }
</style>
@endpush

@section('content')
<div class="wrap">
    <div class="header-action">
        <div>
            <span class="eyebrow">Administrasi</span>
            <h1 class="page-title">Galeri Portofolio Hasil Rias</h1>
        </div>
        <button class="btn-gold" onclick="openModal()"><i class="fa-solid fa-plus"></i> Upload Foto Baru</button>
    </div>

    <div class="portfolio-grid">
        @forelse($portofolios as $item)
            <div class="portfolio-card">
                <a href="{{ asset('storage/' . $item->gambar) }}" 
                   data-fancybox="gallery" 
                   data-caption="<strong>{{ $item->judul }}</strong><br>{{$item->deskripsi }}" 
                   class="portfolio-img-wrapper">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="portfolio-img">
                    <div class="portfolio-img-overlay">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </div>
                </a>

                <div class="portfolio-body">
                    <div class="portfolio-cat">{{ $item->kategori }}</div>
                    <h3 class="portfolio-title">{{ $item->judul }}</h3>
                    <p class="portfolio-desc">{{ Str::limit($item->deskripsi, 60) }}</p>
                    
                    <div class="portfolio-actions">
                        <button class="btn-sm btn-edit" onclick="openModalEdit({{ json_encode($item) }})">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        
                        <form action="{{ route('admin.portofolio.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-delete">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-card">
                Belum ada foto portofolio yang diunggah. Klik tombol "Upload Foto Baru" untuk menambahkan.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Form Upload & Edit (Struktur Fleksibel) -->
<div class="modal-overlay" id="portofolioModal">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Tambah Foto Portofolio</h2>
            <button type="button" class="close-btn" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="portofolioForm" action="{{ route('admin.portofolio.store') }}" method="POST" enctype="multipart/form-data" onsubmit="confirmSave(event, this)">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            
            <!-- Modal Body Scrollable -->
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Portofolio</label>
                    <input type="text" name="judul" id="judul" placeholder="Contoh: Rias Pengantin Sunda Siger Gold" required>
                </div>
                
                <div class="form-group">
                    <label>Kategori Rias / Acara</label>
                    <select name="kategori" id="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>File Foto Gambar</label>
                    <img id="imgPreview" alt="Preview Gambar Saat Ini" style="display:none; max-width:140px; max-height:100px; object-fit:cover; border-radius:8px; margin-bottom:8px; border:1px solid #D8CEC0;">
                    <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png,image/webp">
                    <small style="color: var(--text-muted); font-size: 0.75rem; font-weight: 500; margin-top: 4px; display: block;">Format: JPG, PNG, WEBP (Maksimal 2 MB).</small>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Keterangan riasan atau lokasi acara..."></textarea>
                </div>
            </div>

            <!-- Sticky Action Footer -->
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Portofolio</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', {
        compact: false,
        idle: false,
        animated: true,
        showClass: "f-fadeIn",
        hideClass: "f-fadeOut",
        Images: { zoom: true },
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW"],
                right: ["slideshow", "fullscreen", "close"],
            },
        },
    });

    const modal = document.getElementById('portofolioModal');
    const form = document.getElementById('portofolioForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const imgPreview = document.getElementById('imgPreview');

    function openModal() {
        modalTitle.innerText = "Tambah Foto Portofolio";
        form.action = "{{ route('admin.portofolio.store') }}";
        methodField.value = "POST";
        document.getElementById('gambar').required = true;
        imgPreview.style.display = "none";
        form.reset();
        
        // Kunci scroll halaman utama
        document.body.classList.add('body-no-scroll');
        modal.classList.add('show');
    }

    function openModalEdit(item) {
        modalTitle.innerText = "Edit Foto Portofolio";
        form.action = `/admin/portofolio/${item.id}`;
        methodField.value = "PUT";
        
        document.getElementById('judul').value = item.judul || '';
        document.getElementById('kategori').value = item.kategori || '';
        document.getElementById('deskripsi').value = item.deskripsi || '';
        document.getElementById('gambar').required = false;

        if (item.gambar) {
            imgPreview.src = `/storage/${item.gambar}`;
            imgPreview.style.display = "block";
        } else {
            imgPreview.style.display = "none";
        }
        
        // Kunci scroll halaman utama
        document.body.classList.add('body-no-scroll');
        modal.classList.add('show');
    }

    function closeModal() { 
        // Buka kembali scroll halaman utama saat modal ditutup
        document.body.classList.remove('body-no-scroll');
        modal.classList.remove('show'); 
    }
    function confirmSave(event, form) {
        event.preventDefault();
        const isEdit = methodField.value === "PUT";

        closeModal();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: isEdit ? 'Simpan Perubahan?' : 'Upload Foto Baru?',
                text: isEdit ? "Data portofolio akan diperbarui di sistem." : "Foto portofolio baru akan ditampilkan di galeri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C58F43',
                cancelButtonColor: '#8C8279',
                confirmButtonText: isEdit ? 'Ya, Perbarui!' : 'Ya, Upload!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) { 
                    form.submit(); 
                } else {
                    modal.classList.add('show');
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
                title: 'Hapus Foto Portofolio?',
                text: "Foto yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                form.submit();
            }
        }
    }
</script>
@endpush