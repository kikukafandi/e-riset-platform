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
        Schema::table('petugas', function (Blueprint $table) {
            $table->unsignedBigInteger('kantor_id')->nullable()->after('role');
            $table->foreign('kantor_id')->references('id')->on('kantor_bea_cukai')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->dropForeign(['kantor_id']);
            $table->dropColumn('kantor_id');
        });
    }
};
