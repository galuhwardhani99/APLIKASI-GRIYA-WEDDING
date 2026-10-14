<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    // Explicitly set nama tabel tanpa akhiran 's'
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'kode_reservasi',
        'jenis_acara',
        'detail_acara',
        'lokasi',
        'tanggal_acara',
        'tanggal_pengajuan',
        'status_reservasi',
        'id_akun',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }

    public function jadwal()
    {
        return $this->hasOne(JadwalAcara::class, 'id_reservasi', 'id_reservasi');
    }
}