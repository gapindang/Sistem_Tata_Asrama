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
        Schema::create('riwayat_pelanggaran', function (Blueprint $table) {
            $table->uuid('id_riwayat_pelanggaran')->primary();
            $table->uuid('id_warga');
            $table->uuid('id_pelanggaran');
            $table->uuid('id_petugas');
            $table->date('tanggal');
            $table->enum('status_sanksi', ['belum', 'proses', 'selesai'])->default('belum');
            $table->string('bukti')->nullable();
            $table->timestamps();

            $table->foreign('id_warga')->references('id_warga')->on('warga_asrama')->onDelete('cascade');
            $table->foreign('id_pelanggaran')->references('id_pelanggaran')->on('pelanggaran')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_user')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pelanggarans');
    }
};
