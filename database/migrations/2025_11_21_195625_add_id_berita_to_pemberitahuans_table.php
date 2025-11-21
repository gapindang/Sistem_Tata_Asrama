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
        Schema::table('pemberitahuan', function (Blueprint $table) {
            $table->uuid('id_berita')->nullable()->after('id_user');
            $table->foreign('id_berita')->references('id_berita')->on('berita')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemberitahuan', function (Blueprint $table) {
            $table->dropForeign(['id_berita']);
            $table->dropColumn('id_berita');
        });
    }
};
