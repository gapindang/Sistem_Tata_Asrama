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
        Schema::create('pemberitahuan', function (Blueprint $table) {
            $table->uuid('id_notifikasi')->primary();
            $table->uuid('id_user');
            $table->string('pesan');
            $table->enum('jenis', ['pelanggaran', 'penghargaan', 'denda', 'umum']);
            $table->dateTime('tanggal')->useCurrent();
            $table->boolean('status_baca')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberitahuan');
    }
};
