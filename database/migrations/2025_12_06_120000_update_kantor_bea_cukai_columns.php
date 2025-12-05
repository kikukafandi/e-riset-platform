<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kantor_bea_cukai', function (Blueprint $table) {
            // Make existing fields nullable to accommodate CSV without details
            // Do NOT re-apply unique here to avoid duplicate index errors
            $table->string('kode_kantor')->nullable()->change();
            $table->string('kota')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            // Add eselon column
            if (!Schema::hasColumn('kantor_bea_cukai', 'eselon')) {
                $table->unsignedTinyInteger('eselon')->nullable()->after('jenis_kantor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kantor_bea_cukai', function (Blueprint $table) {
            // Revert to not nullable (unique constraint remains from base migration)
            $table->string('kode_kantor')->nullable(false)->change();
            $table->string('kota')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            // Drop eselon if exists
            if (Schema::hasColumn('kantor_bea_cukai', 'eselon')) {
                $table->dropColumn('eselon');
            }
        });
    }
};
