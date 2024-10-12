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
            'id_setting' => 1,
            'nama_perusahaan' => 'Kasir Aja!',
            'alamat' => 'Jl. Talagasari, No. 35, Kawalimukti, Kec. Kawali, Kab. Ciamis, Prov. Jabar 46253',
            'telepon' => '085722478724',
            'tipe_nota' => 1,
            'diskon' => 5,
            'path_logo' => '/images/logo.png',
            'path_kartu_member' => '/img/member.jpg',
        ]);
    }
}
