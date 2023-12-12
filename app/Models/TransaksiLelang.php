<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiLelang extends Model
{
    use HasFactory;
    protected $guarded = [] ;
    public function penawaran()
    {
        return $this->belongsTo(PenawaranLelang::class, 'id_penawaran', 'id');
    }
    public function Alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id');
    }
}
