<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = [];

    public function produk()
    {
        return $this->hasOne(produk::class,'id_produk', 'id_produk');   //Dalam konteks ini, hubungan yang didefinisikan adalah satu ke satu (one-to-one).
    }   //Model ini memiliki hubungan satu ke satu dengan model produk, yang memungkinkan Anda untuk dengan mudah mengambil data produk yang terkait dengan detail pembelian tertentu.

}
