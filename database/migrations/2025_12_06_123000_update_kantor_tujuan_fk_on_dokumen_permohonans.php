<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_permohonans', function (Blueprint $table) {
            // Change kantor_tujuan to FK referencing kantor_bea_cukai.id
            $table->unsignedBigInteger('kantor_tujuan')->nullable()->change();

            // Add index and FK constraint if not exists
            $table->index('kantor_tujuan', 'dokperm_kantor_tujuan_idx');
            $table->foreign('kantor_tujuan')
                ->references('id')->on('kantor_bea_cukai')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_permohonans', function (Blueprint $table) {
            // Drop FK and index; revert to string
            if (Schema::hasColumn('dokumen_permohonans', 'kantor_tujuan')) {
                $table->dropForeign(['kantor_tujuan']);
                $table->dropIndex('dokperm_kantor_tujuan_idx');
                $table->string('kantor_tujuan')->nullable()->change();
            }
        });
    }
};
