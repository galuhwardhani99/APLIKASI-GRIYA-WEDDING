<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran {{ $reservasi->kode_reservasi }} - Griya Rias Elly Jr.</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--gold:#C58F43;--gold-dark:#A87632;--ink:#241A16;--muted:#8C8279;--line:#EFE8DE;--cream:#FDFBF7}
        *{box-sizing:border-box}body{margin:0;min-height:100vh;background:rgba(36,26,22,.46);color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif}.payment-overlay{min-height:100vh;display:grid;place-items:center;padding:24px;backdrop-filter:blur(7px)}.page{width:min(100%,920px);max-height:calc(100vh - 48px);overflow:auto;background:var(--cream);border:1px solid rgba(255,255,255,.75);border-radius:26px;padding:30px 32px 38px;box-shadow:0 24px 90px rgba(36,26,22,.3);animation:payment-pop .22s ease-out}@keyframes payment-pop{from{opacity:0;transform:translateY(14px) scale(.98)}to{opacity:1;transform:translateY(0) scale(1)}}.back{color:var(--gold-dark);text-decoration:none;font-size:.85rem}.head{display:flex;justify-content:space-between;align-items:end;gap:16px;margin:26px 0 22px}.head h1{font-family:'Playfair Display',serif;margin:0;font-size:clamp(1.7rem,3vw,2.25rem)}.head p{color:var(--muted);margin:7px 0 0;font-size:.88rem}.grid{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(280px,.75fr);gap:22px;align-items:start}.card{background:rgba(255,255,255,.96);border:1px solid rgba(239,232,222,.95);border-radius:20px;padding:28px;box-shadow:0 14px 38px rgba(36,26,22,.08)}.card h2{font-size:1rem;margin:0 0 20px}.summary-row{display:flex;justify-content:space-between;gap:16px;padding:13px 0;border-bottom:1px solid var(--line);font-size:.84rem}.summary-row span{color:var(--muted)}.total{display:flex;justify-content:space-between;margin-top:20px;font-weight:700}.total strong{color:var(--gold);font-size:1.4rem}.methods{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.method{min-height:58px;border:1px solid var(--line);border-radius:13px;padding:13px;cursor:pointer;font-size:.8rem;display:flex;gap:9px;align-items:center;transition:.2s}.method:hover{border-color:var(--gold);transform:translateY(-1px)}.method:has(input:checked){border-color:var(--gold);background:#FDF8EF;box-shadow:0 0 0 2px rgba(197,143,67,.15)}.method input{accent-color:var(--gold)}.pay{width:100%;border:0;border-radius:12px;background:var(--gold);color:#fff;padding:15px;font-weight:700;cursor:pointer;margin-top:22px;box-shadow:0 7px 16px rgba(197,143,67,.25)}.pay:hover{background:var(--gold-dark)}.proof{margin-top:22px;padding-top:20px;border-top:1px solid var(--line)}.proof label{display:block;font-size:.8rem;font-weight:700;margin-bottom:8px}.proof input{width:100%;font-size:.78rem}.upload{border:1px solid var(--gold);background:#fff;color:var(--gold-dark);border-radius:9px;padding:10px 12px;margin-top:10px;cursor:pointer;font-weight:600}.status{display:inline-block;border-radius:999px;background:#FEF3C7;color:#92400E;padding:7px 11px;font-size:.72rem;font-weight:700}.note{color:var(--muted);font-size:.76rem;line-height:1.6}.alert{padding:12px;border-radius:10px;background:#ECFDF5;color:#166534;font-size:.82rem;margin-bottom:16px}@media(max-width:700px){.payment-overlay{padding:10px}.page{max-height:calc(100vh - 20px);padding:22px 14px 28px;border-radius:20px}.grid{grid-template-columns:1fr}.head{display:block}.status{margin-top:12px}.card{padding:22px}.methods{grid-template-columns:1fr 1fr}}
    </style>
</head>
<body>
<div class="payment-overlay">
<main class="page">
    <a class="back" href="{{ route('client.riwayat.transaksi') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke transaksi</a>
    <div class="head"><div><h1>Pembayaran Reservasi</h1><p>{{ $reservasi->kode_reservasi }} · Reservasi sudah disetujui admin</p></div><span class="status">Disetujui</span></div>
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    <div class="grid">
        <section class="card">
            <h2><i class="fa-solid fa-wallet" style="color:var(--gold)"></i> Pilih metode pembayaran</h2>
            <div class="methods">
                <label class="method"><input type="radio" name="payment_method" value="bank_transfer"> Bank / Virtual Account</label>
                <label class="method"><input type="radio" name="payment_method" value="qris"> QRIS</label>
                <label class="method"><input type="radio" name="payment_method" value="gopay"> GoPay</label>
                <label class="method"><input type="radio" name="payment_method" value="shopeepay"> ShopeePay</label>
                <label class="method"><input type="radio" name="payment_method" value="credit_card"> Kartu Kredit</label>
            </div>
            <button class="pay" id="pay-button" data-url="{{ route('reservasi.payment.create', $reservasi) }}"><i class="fa-solid fa-lock"></i> Lanjutkan Pembayaran</button>
            <p class="note" style="margin-top:12px">Pembayaran diproses melalui Midtrans. Pilih metode di atas, lalu ikuti instruksi pada halaman gateway.</p>
        </section>
        <aside class="card">
            <h2>Ringkasan Reservasi</h2>
            <div class="summary-row"><span>Kode</span><strong>{{ $reservasi->kode_reservasi }}</strong></div>
            <div class="summary-row"><span>Paket / layanan</span><strong>{{ $reservasi->nama_paket ?: $reservasi->nama_layanan }}</strong></div>
            <div class="summary-row"><span>Tanggal acara</span><strong>{{ $reservasi->tanggal_acara?->translatedFormat('d F Y') }}</strong></div>
            @php($totalPembayaran = (int) (($reservasi->harga_paket ?: $reservasi->harga_layanan ?: 0) * ($reservasi->jumlah_pesanan ?: 1)))
            <div class="total"><span>Total</span><strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong></div>
            <div class="proof">
                <label for="bukti_transfer">Upload bukti pembayaran manual</label>
                <form action="{{ route('reservasi.payment.proof', $reservasi) }}" method="POST" enctype="multipart/form-data">
                    @csrf<input id="bukti_transfer" type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required>
                    <button class="upload" type="submit"><i class="fa-solid fa-upload"></i> {{ $reservasi->bukti_transfer ? 'Ganti Bukti' : 'Upload Bukti' }}</button>
                </form>
                <p class="note">Format JPG, PNG, atau PDF. Maksimal 2 MB. Bukti dapat dilihat admin untuk diverifikasi.</p>
            </div>
        </aside>
    </div>
</main>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', async function(){
    const button=this, method=document.querySelector('input[name="payment_method"]:checked')?.value;
    if(!method){Swal.fire('Pilih metode pembayaran','Silakan pilih salah satu metode pembayaran.','info');return;}
    button.disabled=true;button.textContent='Memuat pembayaran...';
    try{const res=await fetch(button.dataset.url,{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify({payment_method:method})});const data=await res.json();if(!res.ok)throw new Error(data.message||'Pembayaran gagal dibuat.');window.snap.pay(data.token,{onSuccess:()=>location.reload(),onPending:()=>location.reload(),onError:()=>Swal.fire('Pembayaran gagal','Silakan coba lagi.','error'),onClose:()=>{button.disabled=false;button.innerHTML='<i class="fa-solid fa-lock"></i> Lanjutkan Pembayaran';}})}catch(e){Swal.fire('Gagal',e.message,'error');button.disabled=false;button.innerHTML='<i class="fa-solid fa-lock"></i> Lanjutkan Pembayaran';}
});
</script>
</body>
</html>
