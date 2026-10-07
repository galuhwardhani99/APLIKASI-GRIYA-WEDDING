<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama_paket',
        'kategori',
        'harga',
        'deskripsi',
        'status',
    ];
}