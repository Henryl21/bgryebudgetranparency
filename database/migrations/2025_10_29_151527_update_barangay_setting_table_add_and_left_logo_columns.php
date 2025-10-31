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
        Schema::table('barangay_settings', function (Blueprint $table) {
            $table->string('left_logo')->nullable();
            $table->renameColumn('logo', 'right_logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangay_settings', function (Blueprint $table) {
            $table->dropColumn('left_logo')->nullable();
            $table->renameColumn('right_logo', 'logo');
        });
    }
};
