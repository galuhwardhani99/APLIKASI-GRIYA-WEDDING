<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPaket extends Model
{
    protected $table = 'kategori_pakets';

    protected $fillable = ['nama_kategori'];

    public function pakets(): HasMany
    {
        return $this->hasMany(Paket::class, 'kategori_paket_id');
    }
}
