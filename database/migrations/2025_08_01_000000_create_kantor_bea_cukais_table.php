<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kantor_bea_cukais', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kantor');
            
            // Kolom-kolom ini dibuat nullable sesuai request update Anda sebelumnya
            $table->string('kode_kantor')->nullable()->unique();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->text('alamat')->nullable();
            
            $table->enum('jenis_kantor', ['kanwil', 'kppbc', 'kpu']);
            $table->unsignedTinyInteger('eselon')->nullable(); // Langsung tambahkan di sini
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kantor_bea_cukais');
    }
};