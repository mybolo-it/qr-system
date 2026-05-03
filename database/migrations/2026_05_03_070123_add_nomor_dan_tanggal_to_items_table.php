<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            // Menambahkan kolom nomor surat dan tanggal surat
            $table->string('nomor_surat')->after('nama')->nullable();
            $table->date('tanggal_surat')->after('nomor_surat')->nullable();
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'tanggal_surat']);
        });
    }
};
