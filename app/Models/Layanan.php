<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $primaryKey = 'id_layanan';

    protected $fillable = [
        'nama_layanan',
        'variasi',
        'harga',
        'deskripsi',
        'foto',
        'unggulan',
        'status',
    ];

    protected $casts = [
        'unggulan' => 'boolean',
    ];
}
