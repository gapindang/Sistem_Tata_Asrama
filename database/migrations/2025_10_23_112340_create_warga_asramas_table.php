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
        Schema::create('warga_asrama', function (Blueprint $table) {
            $table->uuid('id_warga')->primary();
            $table->string('nama', 100);
            $table->string('nim', 30)->unique();
            $table->string('kamar', 20);
            $table->string('angkatan', 10);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga_asramas');
    }
};
