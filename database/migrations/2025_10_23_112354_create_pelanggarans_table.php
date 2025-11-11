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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->uuid('id_pelanggaran')->primary();
            $table->uuid('id_warga');
            $table->string('nama_pelanggaran', 150);
            $table->string('kategori', 100);
            $table->integer('poin');
            $table->decimal('denda', 10, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->foreign('id_warga')->references('id_warga')->on('warga_asrama')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
