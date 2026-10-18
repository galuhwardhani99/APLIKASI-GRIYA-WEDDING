<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $casts = [
        'tgl_reservasi' => 'datetime',
        'tgl_acara' => 'date',
        'tanggal_acara' => 'date',
        'tanggal_pengajuan' => 'datetime',
    ];

    protected $fillable = [
        'kode_reservasi',
        'tgl_reservasi',
        'tgl_acara',
        'lokasi_acara',
        'biaya_sewa',
        'jenis_acara',
        'detail_acara',
        'lokasi',
        'tanggal_acara',
        'tanggal_pengajuan',
        'status_reservasi',
        'id_akun', // Disesuaikan dengan migration (sebelumnya id_user)
        'id_jadwal',
        'id_paket',
        'jenis_pesanan',
        'id_layanan',
        'nama_paket',
        'harga_paket',
        'nama_layanan',
        'harga_layanan',
        'jumlah_pesanan',
        'waktu_mulai',
        'waktu_selesai',
        'catatan',
        'bukti_transfer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalAcara::class, 'id_jadwal', 'id_jadwal');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }
}