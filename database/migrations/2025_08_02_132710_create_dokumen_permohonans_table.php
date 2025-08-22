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
            $table->string('judul_riset');
            $table->text('proposal');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('unit_kerja_lokasi_riset');
            $table->text('jenis_permohonan_data');
            $table->text('data_statistik_yang_diminta')->nullable();
            $table->text('kuisioner')->nullable();
            $table->text('pedoman_wawancara')->nullable();
            $table->text('proposal_fgd')->nullable();
            $table->enum('status',['dokumen_tidak_lengkap','ditolak','diterima','diproses']);
            $table->timestamps();
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
