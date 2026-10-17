<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paket extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama_paket',
        'kategori_paket_id',
        'harga',
        'deskripsi',
        'foto',
        'unggulan',
        'status',
    ];

    protected $casts = [
        'unggulan' => 'boolean',
    ];

    public function kategoriPaket(): BelongsTo
    {
        return $this->belongsTo(KategoriPaket::class, 'kategori_paket_id');
    }
}
