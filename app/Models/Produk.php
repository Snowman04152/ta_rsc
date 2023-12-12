<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    public function varian()
    {
        return $this->hasMany(Varian::class, 'id_produk', 'id');
    }
}
