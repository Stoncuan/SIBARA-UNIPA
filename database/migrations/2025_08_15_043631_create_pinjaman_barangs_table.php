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
        Schema::create('pinjaman_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 255);
            $table->text('keperluan_barang');
            $table->string('tanggal_pinjam_barang', 100);
            $table->string('tanggal_barang_kembali', 100)->nullable(true);
            $table->string('nama_penanggung_jawab');
            $table->string('status_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman_barangs');
    }
};
