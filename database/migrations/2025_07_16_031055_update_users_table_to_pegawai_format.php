<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ganti name menjadi nama
            $table->renameColumn('name', 'nama');

            // Tambahan kolom
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatan')->nullOnDelete();
            $table->foreignId('pangkat_id')->nullable()->constrained('pangkat')->nullOnDelete();
            $table->foreignId('id_atasan')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('instansi_id')->nullable()->constrained('instansi')->nullOnDelete();

            $table->string('username')->unique()->after('nama');
            $table->string('nip')->unique()->nullable();
            $table->string('nik')->unique();
            $table->string('jenis_pegawai')->nullable();
            $table->string('no_wa')->nullable();

            // Email jadi nullable jika tidak selalu digunakan
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nama', 'name');
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['pangkat_id']);
            $table->dropForeign(['id_atasan']);
            $table->dropForeign(['instansi_id']);

            $table->dropColumn([
                'jabatan_id', 'pangkat_id', 'id_atasan',
                'instansi_id', 'username', 'nip',
                'nik', 'jenis_pegawai', 'no_wa'
            ]);

            $table->string('email')->nullable(false)->change();
        });
    }
};

