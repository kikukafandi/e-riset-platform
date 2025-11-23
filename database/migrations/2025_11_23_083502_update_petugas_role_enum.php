<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First update any super_user to super_admin
        DB::table('petugas')->where('role', 'super_user')->update(['role' => 'pelaksana']);
        
        // Then modify the enum
        DB::statement("ALTER TABLE petugas MODIFY COLUMN role ENUM('super_admin','pelaksana','eselon_iv','eselon_iii','eselon_ii')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE petugas MODIFY COLUMN role ENUM('super_user','pelaksana','eselon_iv','eselon_iii','eselon_ii')");
    }
};
