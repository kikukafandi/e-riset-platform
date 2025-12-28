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
        Schema::create('dokumen_permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('topik_tujuan_riset');
            $table->string('judul_riset');
            $table->foreignId('kantor_tujuan')->constrained('kantor_bea_cukais');
            $table->string('jenis_permohonan_data'); // Diubah ke string
            $table->text('data_statistik_yang_diminta')->nullable();
            $table->string('proposal');
            $table->string('surat_pengantar');
            $table->string('surat_pernyataan');
            $table->string('kuisioner')->nullable();
            $table->string('pedoman_wawancara')->nullable();
            $table->string('proposal_fgd')->nullable();
            $table->enum('status', ['dokumen_tidak_lengkap', 'ditolak', 'diterima', 'diproses'])->default('diproses');
            $table->timestamps();
            $table->string('service_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_permohonans');
    }
};
