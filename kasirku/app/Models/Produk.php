<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    // Di model Produk
    
    protected $guarded = [];        //guarded: Ini adalah array yang berisi kolom-kolom yang tidak boleh diisi secara massal. Dalam contoh ini, arraynya kosong ([]), yang berarti semua kolom dapat diisi.
    protected $fillable = ['nama_produk', 'kode_produk', 'harga_jual', 'diskon', 'stok'];  // Pastikan stok ada di sini 
    //Ini adalah array yang berisi kolom-kolom yang diperbolehkan untuk diisi secara massal. Hanya kolom-kolom yang terdaftar di sini yang dapat diisi saat menggunakan metode create() atau update().
}
