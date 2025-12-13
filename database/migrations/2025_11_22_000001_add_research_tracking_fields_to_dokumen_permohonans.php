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
        Schema::table('dokumen_permohonans', function (Blueprint $table) {
            // Nomor layanan (format NNNN-YYYY)
            $table->string('service_number', 11)->nullable()->unique()->after('status');
            $table->date('tanggal_persetujuan')->nullable()->after('status');
            $table->date('deadline_penelitian')->nullable()->after('tanggal_persetujuan');
            $table->string('doi_number')->nullable()->after('deadline_penelitian');
            $table->string('file_paper_pdf')->nullable()->after('doi_number');
            $table->enum('status_penelitian', ['belum_dimulai', 'sedang_berjalan', 'selesai', 'terlambat'])->default('belum_dimulai')->after('file_paper_pdf');
            $table->boolean('dapat_perijinan_lagi')->default(true)->after('status_penelitian');
            $table->string('kantor_tujuan')->nullable()->after('dapat_perijinan_lagi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_persetujuan',
                'deadline_penelitian', 
                'doi_number',
                'file_paper_pdf',
                'status_penelitian',
                'dapat_perijinan_lagi',
                'kantor_tujuan'
            ]);
        });
    }
};