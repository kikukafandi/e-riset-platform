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
        Schema::create('kantor_bea_cukai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kantor');
            $table->string('kode_kantor')->unique();
            $table->string('provinsi');
            $table->string('kota');
            $table->text('alamat');
            $table->enum('jenis_kantor', ['kanwil', 'kppbc', 'kpu']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantor_bea_cukai');
    }
};