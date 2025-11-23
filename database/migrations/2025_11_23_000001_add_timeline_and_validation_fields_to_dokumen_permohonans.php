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
            // Timeline fields
            $table->timestamp('tanggal_draft')->nullable()->after('status');
            $table->timestamp('tanggal_submit')->nullable()->after('tanggal_draft');
            $table->timestamp('tanggal_validasi_admin')->nullable()->after('tanggal_submit');
            $table->timestamp('tanggal_verifikasi_pejabat')->nullable()->after('tanggal_validasi_admin');
            $table->timestamp('tanggal_mulai_riset')->nullable()->after('tanggal_verifikasi_pejabat');
            
            // Paper submission and validation
            $table->string('paper_file')->nullable()->after('file_paper_pdf');
            $table->enum('paper_validation_status', ['pending', 'valid', 'invalid'])->default('pending')->after('paper_file');
            $table->text('paper_validation_message')->nullable()->after('paper_validation_status');
            $table->timestamp('paper_submitted_at')->nullable()->after('paper_validation_message');
            $table->timestamp('paper_validated_at')->nullable()->after('paper_submitted_at');
            
            // Validation status for admin
            $table->enum('admin_validation_status', ['pending', 'approved', 'rejected'])->default('pending')->after('paper_validated_at');
            $table->text('admin_validation_message')->nullable()->after('admin_validation_status');
            $table->timestamp('admin_validated_at')->nullable()->after('admin_validation_message');
            
            // Letter generation
            $table->string('generated_letter_path')->nullable()->after('admin_validated_at');
            $table->timestamp('letter_generated_at')->nullable()->after('generated_letter_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_draft',
                'tanggal_submit',
                'tanggal_validasi_admin',
                'tanggal_verifikasi_pejabat',
                'tanggal_mulai_riset',
                'paper_file',
                'paper_validation_status',
                'paper_validation_message',
                'paper_submitted_at',
                'paper_validated_at',
                'admin_validation_status',
                'admin_validation_message',
                'admin_validated_at',
                'generated_letter_path',
                'letter_generated_at'
            ]);
        });
    }
};