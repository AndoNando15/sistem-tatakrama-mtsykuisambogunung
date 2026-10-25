<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 30)->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jabatan_pokok')->nullable();
            $table->string('jabatan_tambahan')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_mulai_tugas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'jabatan',
                'nuptk',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'pendidikan_terakhir',
                'jabatan_pokok',
                'jabatan_tambahan',
                'alamat',
                'tanggal_mulai_tugas',
            ]);
        });
    }
};
