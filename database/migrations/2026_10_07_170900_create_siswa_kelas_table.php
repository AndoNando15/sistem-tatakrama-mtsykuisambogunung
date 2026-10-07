<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->timestamps();

            // Satu siswa hanya berada di satu kelas pada satu tahun ajaran
            $table->unique(['siswa_id', 'tahun_ajaran_id']);
        });

        // Backfill: catat kelas saat ini untuk semua siswa pada tahun ajaran aktif
        $tahunAktif = DB::table('tahun_ajaran')->where('is_active', true)->first();

        if ($tahunAktif) {
            DB::table('siswa')->orderBy('id')->each(function ($siswa) use ($tahunAktif) {
                DB::table('siswa_kelas')->insert([
                    'siswa_id'        => $siswa->id,
                    'kelas_id'        => $siswa->kelas_id,
                    'tahun_ajaran_id' => $tahunAktif->id,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_kelas');
    }
};
