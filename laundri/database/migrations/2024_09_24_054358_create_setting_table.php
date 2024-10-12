<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')
                ->unique();
            $table->string('telpon');
            $table->text('about')
                ->nullable();
            $table->string('alamat')
                ->nullable();
            $table->char('kode_pos', 5)
                ->nullable();
            $table->string('kota')
                ->nullable();
            $table->string('provinsi')
                ->nullable();
            $table->string('path_image')
                ->nullable();
            $table->string('path_image_header')
                ->nullable();
            $table->string('path_image_footer')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
