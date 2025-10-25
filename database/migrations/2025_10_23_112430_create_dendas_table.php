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
        Schema::create('denda', function (Blueprint $table) {
            $table->uuid('id_denda')->primary();
            $table->uuid('id_riwayat_pelanggaran')->unique();
            $table->decimal('nominal', 10, 2);
            $table->enum('status_bayar', ['belum', 'dibayar'])->default('belum');
            $table->date('tanggal_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();

            $table->foreign('id_riwayat_pelanggaran')->references('id_riwayat_pelanggaran')->on('riwayat_pelanggaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
