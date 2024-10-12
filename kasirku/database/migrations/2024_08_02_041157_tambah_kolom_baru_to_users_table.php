<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('id'); // Menambahkan kolom 'foto'
            $table->tinyInteger('level')->default(0)->after('foto'); // Menambahkan kolom 'level'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto', 'level']); // Menghapus kolom 'foto' dan 'level'
        });
    }
};
