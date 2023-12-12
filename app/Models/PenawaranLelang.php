<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranLelang extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function produk_lelang()
    {
        return $this->belongsTo(ProdukLelang::class, 'id_produk_lelang', 'id');
    }
}
