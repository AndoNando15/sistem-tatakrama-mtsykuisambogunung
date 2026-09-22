<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('MTs Negeri Tatakrama');
            $table->string('npsn')->nullable()->default('12345678');
            $table->text('alamat_sekolah')->nullable()->default('Jl. Pendidikan No. 1, Kota');
            $table->string('nama_kepala_sekolah')->nullable()->default('Drs. H. Ahmad Dahlan, M.Pd');
            $table->string('nip_kepala_sekolah')->nullable()->default('197001011995031001');
            $table->string('nama_guru_bk')->nullable()->default('Siti Rahmawati, S.Psi');
            $table->string('nip_guru_bk')->nullable()->default('198205102008012003');
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengaturan_sistem');
    }
};
