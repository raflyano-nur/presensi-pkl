<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('nis');
            $table->string('email');
            $table->string('password');
            $table->string('nm_lengkap');
            $table->enum('jk', ['L', 'P']);
            $table->string('agama');
            $table->foreignId('kelasID')->constrained('kelas', 'kelasID')->onDelete('cascade');
            $table->foreignId('perusahaanID')->constrained('perusahaan', 'perusahaanID')->onDelete('cascade');
            $table->integer('no_tlp');
            $table->string('foto');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
