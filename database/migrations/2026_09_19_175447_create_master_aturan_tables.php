<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Kategori K1 - K7
        Schema::create('kategori_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // K1 s.d K7
            $table->string('nama_kategori');
            $table->enum('sifat_akumulasi', ['semester', 'tahunan', 'selamanya'])->default('semester');
            $table->timestamps();
        });

        // Master Jenis Pelanggaran & Poin (Soft History via is_active)
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_pelanggaran')->onDelete('cascade');
            $table->string('kode_pelanggaran')->nullable();
            $table->text('uraian_pelanggaran');
            $table->integer('poin');
            $table->text('sanksi_default')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Ambang Sanksi Kumulasi
        Schema::create('aturan_sanksi_kumulasi', function (Blueprint $table) {
            $table->id();
            $table->integer('min_poin');
            $table->integer('max_poin');
            $table->text('tindakan');
            $table->char('nilai_sikap', 1)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('aturan_sanksi_kumulasi');
        Schema::dropIfExists('jenis_pelanggaran');
        Schema::dropIfExists('kategori_pelanggaran');
    }
};