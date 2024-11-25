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
        Schema::create('bkphs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('wilayah');
            $table->text('alamat');
            $table->bigInteger('kontak');
            $table->string('jenis_hutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bkphs');
    }
};
