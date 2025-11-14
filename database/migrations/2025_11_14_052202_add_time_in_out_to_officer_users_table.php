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
    Schema::table('officer_users', function (Blueprint $table) {
        $table->timestamp('time_in')->nullable()->after('remember_token');
        $table->timestamp('time_out')->nullable()->after('time_in');
    });
}

public function down(): void
{
    Schema::table('officer_users', function (Blueprint $table) {
        $table->dropColumn(['time_in', 'time_out']);
    });
}

    
};
