<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('id');
            $table->string('nama_lengkap')->nullable()->after('password');
            $table->string('nip_nik')->nullable()->after('nama_lengkap');
            $table->string('no_hp')->nullable()->after('nip_nik');
            $table->boolean('is_active')->default(true)->after('no_hp'); // Soft History Penanda Aktif/Nonaktif
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nama_lengkap', 'nip_nik', 'no_hp', 'is_active']);
        });
    }
};