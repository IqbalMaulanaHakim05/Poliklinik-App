<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_rm')->nullable();
            $table->enum('role', ['dokter', 'pasien'])->nullable();
            $table->foreignId('id_poli')->nullable()->constrained('poli')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_poli');
            $table->dropColumn(['nama', 'alamat', 'no_ktp', 'no_hp', 'no_rm', 'role']);
        });
    }
};
