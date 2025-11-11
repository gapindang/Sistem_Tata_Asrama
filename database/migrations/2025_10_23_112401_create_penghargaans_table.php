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
        Schema::create('penghargaan', function (Blueprint $table) {
            $table->uuid('id_penghargaan')->primary();
            $table->uuid('id_warga');
            $table->string('nama_penghargaan', 150);
            $table->integer('poin_reward');
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
        Schema::dropIfExists('penghargaans');
    }
};
