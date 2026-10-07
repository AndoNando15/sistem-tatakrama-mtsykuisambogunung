<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nomor_induk_kemenag')->nullable()->after('nis_nisn');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('nama_ibu')->nullable()->after('nama_orang_tua'); // nama_orang_tua bisa difungsikan sebagai nama ayah
            $table->string('rt')->nullable()->after('no_hp_orang_tua');
            $table->string('asal_sekolah')->nullable()->after('rt');
        });
    }

    public function down(): void {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_induk_kemenag', 
                'tempat_lahir', 
                'tanggal_lahir', 
                'nama_ibu', 
                'rt', 
                'asal_sekolah'
            ]);
        });
    }
};