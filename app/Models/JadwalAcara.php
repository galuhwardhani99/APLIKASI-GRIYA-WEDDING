<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAcara extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jadwal';
    protected $table = 'jadwal_acara';

    protected $fillable = [
        'tgl_acara',
        'waktu_mulai',
        'waktu_selesai',
        'status_jadwal',
    ];

    public function reservasi()
    {
        return $this->hasOne(Reservasi::class, 'id_jadwal', 'id_jadwal');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}
