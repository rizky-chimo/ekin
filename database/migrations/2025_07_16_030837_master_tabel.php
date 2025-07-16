<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('pangkat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('golongan');
            $table->timestamps();
        });

        Schema::create('indikator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->text('uraian');
            $table->timestamps();
        });

        Schema::create('rhk_pejabat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('cascade');
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->text('uraian');
            $table->timestamps();
        });

        Schema::create('rhk_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('indikator')->onDelete('cascade');
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->text('uraian');
            $table->float('nilai')->nullable();
            $table->year('tahun');
            $table->timestamps();
        });

        Schema::create('uraian_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_id')->constrained('indikator')->onDelete('cascade');
            $table->foreignId('rhk_staff_id')->constrained('rhk_staff')->onDelete('cascade');
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->text('uraian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uraian_tugas');
        Schema::dropIfExists('rhk_staff');
        Schema::dropIfExists('rhk_pejabat');
        Schema::dropIfExists('indikator');
        Schema::dropIfExists('pangkat');
        Schema::dropIfExists('jabatan');
        Schema::dropIfExists('instansi');
    }
};
