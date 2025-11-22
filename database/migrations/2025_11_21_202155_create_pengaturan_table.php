<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('pengaturan')->insert([
            [
                'key' => 'nama_asrama',
                'value' => 'Asrama Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_asrama',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'alamat_asrama',
                'value' => 'Jl. Contoh No. 123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'telepon_asrama',
                'value' => '(021) 1234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email_asrama',
                'value' => 'info@asrama.ac.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'kepala_asrama',
                'value' => 'Nama Kepala Asrama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
