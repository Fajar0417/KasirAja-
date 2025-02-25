<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $guarded = [];

    // Relasi dengan model Pembelian
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
}
//hasMany(): Ini adalah metode yang digunakan untuk mendefinisikan relasi "satu ke banyak".
