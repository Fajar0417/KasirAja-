<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'id_setting'=>1,
            'nama_perusahaan' => 'DIIFY.com',
            'alamat'=> 'Jl.Talagasari dusun,pogorsari.desa,kawalimukti.kec.kawali',
            'telepon'=> '085861049565',
            'tipe_nota' => 1, // kalau satu tu tipe nota nya kecil 
            'path_logo'=>'/img/kasir.png',
            'email'=>'SmartKasir@gmail.com',
        ]);
    }
}
