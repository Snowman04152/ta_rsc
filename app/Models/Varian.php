<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    use HasFactory;
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
        

    }
}
