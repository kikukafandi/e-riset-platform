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
        Schema::create('topik_usage_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topik_riset_id')->constrained('topik_risets')->cascadeOnDelete();
            $table->integer('usage_count')->default(0);
            $table->year('year');
            $table->tinyInteger('month');
            $table->timestamps();
            
            $table->unique(['topik_riset_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_usage_stats');
    }
};