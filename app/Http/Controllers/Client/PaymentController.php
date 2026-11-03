<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show(Reservasi $reservasi)
    {
        abort_unless($reservasi->id_akun === auth()->id(), 403);
        abort_if(in_array($reservasi->payment_status, ['paid', 'proof_verified'], true), 403, 'Pembayaran reservasi ini sudah diterima.');
        abort_unless($reservasi->status_reservasi === 'Disetujui', 403, 'Reservasi belum disetujui admin.');

        return view('client.pembayaran', compact('reservasi'));
    }

    public function create(Reservasi $reservasi)
    {
        abort_unless($reservasi->id_akun === auth()->id(), 403);

        if (in_array($reservasi->payment_status, ['paid', 'proof_verified'], true)) {
            return response()->json(['message' => 'Pembayaran reservasi ini sudah diterima admin.'], 422);
        }

        if ($reservasi->status_reservasi !== 'Disetujui') {
            return response()->json(['message' => 'Pembayaran tersedia setelah reservasi disetujui admin.'], 422);
        }

        $paymentMethod = request()->validate([
            'payment_method' => ['nullable', 'in:bank_transfer,qris,gopay,shopeepay,credit_card'],
        ])['payment_method'] ?? null;

        if (! config('services.midtrans.server_key')) {
            return response()->json(['message' => 'Payment gateway belum dikonfigurasi oleh admin.'], 503);
        }

        if ($reservasi->payment_status === 'paid') {
            return response()->json(['message' => 'Reservasi ini sudah dibayar.'], 409);
        }

        $amount = $this->amount($reservasi);
        abort_if($amount < 1, 422, 'Total pembayaran belum tersedia.');

        // Order ID baru di setiap percobaan, karena Midtrans menolak order_id yang sudah pernah dipakai.
        $orderId = 'GRIYA-' . $reservasi->kode_reservasi . '-' . Str::upper(Str::random(5));
        $reservasi->update(['payment_order_id' => $orderId]);

        $baseUrl = config('services.midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => array_filter([
                'first_name' => $reservasi->user?->name ?? 'Pelanggan',
                'email' => $reservasi->user?->email,
                'phone' => $reservasi->user?->phone ?: $reservasi->user?->no_hp,
            ]),
            'item_details' => [[
                'id' => $reservasi->kode_reservasi,
                'price' => $amount,
                'quantity' => 1,
                'name' => 'Pembayaran reservasi ' . $reservasi->kode_reservasi,
            ]],
        ];

        // Kirim enabled_payments hanya kalau ada isinya.
        // Kalau null/kosong, Midtrans bisa menampilkan "No payment channels available".
        if ($paymentMethod) {
            $payload['enabled_payments'] = [$paymentMethod];
        }

        $response = Http::withBasicAuth(config('services.midtrans.server_key'), '')
            ->acceptJson()
            ->post($baseUrl, $payload);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal membuat transaksi pembayaran.',
                'detail' => $response->json('error_messages') ?? $response->json('status_message'),
            ], 502);
        }

        return response()->json([
            'token' => $response->json('token'),
            'order_id' => $orderId,
        ]);
    }

    public function uploadProof(Request $request, Reservasi $reservasi)
    {
        abort_unless($reservasi->id_akun === auth()->id(), 403);

        abort_if($reservasi->payment_status === 'proof_verified', 403, 'Bukti pembayaran sudah diterima admin.');

        $validated = $request->validate([
            'bukti_transfer' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'bukti_transfer.required' => 'Pilih file bukti pembayaran.',
            'bukti_transfer.mimes' => 'Bukti harus berupa JPG, PNG, atau PDF.',
            'bukti_transfer.max' => 'Ukuran bukti maksimal 2 MB.',
        ]);

        if ($reservasi->bukti_transfer && Storage::disk('public')->exists($reservasi->bukti_transfer)) {
            Storage::disk('public')->delete($reservasi->bukti_transfer);
        }

        $path = $validated['bukti_transfer']->store('bukti-pembayaran', 'public');
        $reservasi->update(['bukti_transfer' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu verifikasi admin.');
    }

    public function notification(Request $request)
    {
        $data = $request->all();

        $signature = hash(
            'sha512',
            ($data['order_id'] ?? '') .
            ($data['status_code'] ?? '') .
            ($data['gross_amount'] ?? '') .
            config('services.midtrans.server_key')
        );
        abort_unless(hash_equals($signature, (string) ($data['signature_key'] ?? '')), 403);

        $reservasi = Reservasi::where('payment_order_id', $data['order_id'] ?? '')->first();

        // Order ID lama (percobaan sebelumnya) tidak lagi tercatat; cukup balas OK supaya Midtrans tidak mengulang.
        if (! $reservasi) {
            return response()->json(['success' => true]);
        }

        $status = $data['transaction_status'] ?? 'pending';
        $fraud = $data['fraud_status'] ?? null;

        $paymentStatus = match (true) {
            $status === 'settlement' => 'paid',
            $status === 'capture' && $fraud !== 'challenge' => 'paid',
            $status === 'expire' => 'expired',
            default => $status,
        };

        $reservasi->update([
            'payment_status' => $paymentStatus,
            'paid_at' => $paymentStatus === 'paid' ? now() : $reservasi->paid_at,
        ]);

        return response()->json(['success' => true]);
    }

    private function amount(Reservasi $reservasi): int
    {
        return (int) (($reservasi->harga_paket ?: $reservasi->harga_layanan ?: 0) * ($reservasi->jumlah_pesanan ?: 1));
    }
}
