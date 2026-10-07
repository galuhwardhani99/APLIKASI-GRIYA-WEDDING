@extends('layouts.app')

@section('title', 'Detail Acara & Pemesan')

@section('content')
<style>
    /* Styling khusus untuk halaman Checkout/Reservasi */
    body {
        background-color: #FDFBF8; /* Warna latar belakang krem terang */
    }
    
    .checkout-wrapper {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .card {
        background: #FFFFFF;
        border: 1px solid #EFEAE1;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #333333;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: #B9833B;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #4A4A4A;
        margin-bottom: 8px;
    }

    input[type="text"], 
    textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #E0DCD3;
        border-radius: 8px;
        background-color: #FAFAFA;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.95rem;
        color: #333;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus, 
    textarea:focus {
        outline: none;
        border-color: #B9833B;
        background-color: #FFFFFF;
    }

    /* Skema & Metode Pembayaran Radio Buttons */
    .radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .radio-card {
        border: 1px solid #E0DCD3;
        border-radius: 8px;
        padding: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }

    .radio-card:hover {
        border-color: #B9833B;
    }

    .radio-card.active {
        border-color: #B9833B;
        background-color: #FDF9F1;
    }

    .radio-info strong {
        display: block;
        font-size: 0.95rem;
        color: #333;
    }

    .radio-info span {
        font-size: 0.85rem;
        color: #888;
    }
    
    .radio-input {
        accent-color: #B9833B;
        width: 18px;
        height: 18px;
    }

    .payment-methods .radio-card {
        margin-bottom: 12px;
    }

    /* Rincian Tagihan Styles */
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: #555;
    }

    .summary-divider {
        border-top: 1px dashed #E0DCD3;
        margin: 20px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.1rem;
        font-weight: 800;
        color: #B9833B;
        margin-bottom: 24px;
    }

    .btn-submit {
        width: 100%;
        background-color: #B9833B;
        color: #FFFFFF;
        border: none;
        padding: 16px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #9C6F32;
    }

    @media (max-width: 768px) {
        .checkout-wrapper {
            grid-template-columns: 1fr;
        }
        .form-row, .radio-group {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="checkout-wrapper">
    <!-- Kiri: Form Detail Acara & Pemesan -->
    <div class="card form-section">
        <h2 class="card-title">📄 Detail Acara & Pemesan</h2>
        
        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Pemesan</label>
                <input type="text" id="nama" name="nama" value="Siti Rahmawati" readonly>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">No. WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="081234567890">
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal Acara</label>
                    <!-- Menggunakan text input untuk menyamai UI, dalam produksi gunakan type="date" -->
                    <input type="text" id="tanggal" name="tanggal" value="06 Oktober 2026">
                </div>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Acara Lengkap</label>
                <textarea id="lokasi" name="lokasi" rows="3">Gedung Kencana, Jl. Mawar No. 12, Kediri</textarea>
            </div>

            <div class="form-group">
                <label>Skema Pembayaran</label>
                <div class="radio-group">
                    <label class="radio-card active">
                        <div class="radio-info">
                            <strong>Uang Muka (DP 30%)</strong>
                            <span>Rp 2.250.000</span>
                        </div>
                        <input type="radio" name="skema_bayar" value="dp" class="radio-input" checked>
                    </label>
                    <label class="radio-card">
                        <div class="radio-info">
                            <strong>Pelunasan 100%</strong>
                            <span>Rp 7.500.000</span>
                        </div>
                        <input type="radio" name="skema_bayar" value="lunas" class="radio-input">
                    </label>
                </div>
            </div>
        </form>
    </div>

    <!-- Kanan: Rincian Tagihan -->
    <div class="card summary-section">
        <h2 class="card-title">Rincian Tagihan</h2>
        
        <div class="summary-item">
            <span>Paket Rias Akad & Resepsi Gold</span>
            <span>Rp 7.500.000</span>
        </div>
        <div class="summary-item">
            <span>Biaya Layanan & Admin</span>
            <span>Rp 0</span>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-total">
            <span>Total Yang Harus Dibayar (DP):</span>
            <span>Rp 2.250.000</span>
        </div>

        <div class="form-group payment-methods">
            <label>Metode Pembayaran (Payment Gateway)</label>
            
            <label class="radio-card active" style="grid-template-columns: 1fr;">
                <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                    <span>📱</span>
                    <strong style="flex-grow: 1;">QRIS Instant</strong>
                    <input type="radio" name="metode_bayar" value="qris" class="radio-input" checked>
                </div>
            </label>

            <label class="radio-card" style="grid-template-columns: 1fr;">
                <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                    <span>🏦</span>
                    <strong style="flex-grow: 1; font-weight: normal;">Transfer VA Bank BCA / Mandiri</strong>
                    <input type="radio" name="metode_bayar" value="va" class="radio-input">
                </div>
            </label>
        </div>

        <button type="submit" class="btn-submit">BAYAR SEKARANG VIA PAYMENT GATEWAY</button>
    </div>
</div>

<script>
    // Script sederhana untuk menambahkan kelas 'active' pada radio card yang dipilih
    document.querySelectorAll('.radio-input').forEach(input => {
        input.addEventListener('change', function() {
            const groupName = this.getAttribute('name');
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(radio => {
                if(radio.checked) {
                    radio.closest('.radio-card').classList.add('active');
                } else {
                    radio.closest('.radio-card').classList.remove('active');
                }
            });
        });
    });
</script>
@endsection