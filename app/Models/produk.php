<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; //untuk menghubungkan ke tabel produk
    protected $primaryKey = 'id_produk';//
    protected $guarded = [];
}
