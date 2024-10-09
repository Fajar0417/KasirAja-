<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';  // Menyatakan bahwa model ini terhubung dengan tabel kategori di database.
    protected $primaryKey = 'id_kategori';  //primary key dari tabel adalah id_kategori,
    protected $guarded = [];    // tidak ada kolom yang dilindungi, yang artinya semua kolom dapat diisi secara massal.
}