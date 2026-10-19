<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAcara extends Model
{
    use HasFactory;

    protected $table = 'jadwal_acaras'; // Sesuai nama tabel di database kamu
    protected $primaryKey = 'id_jadwal'; // Sesuai primary key di ERD

    protected $fillable = [
        'divalidasi_oleh',
        'id_reservasi',
        'waktu_mulai',
        'waktu_selesai',
        'status_validasi',
    ];

    // Relasi ke tabel Reservasi
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi');
    }

    // Relasi ke Admin yang memvalidasi
    public function admin()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh', 'id');
    }
}