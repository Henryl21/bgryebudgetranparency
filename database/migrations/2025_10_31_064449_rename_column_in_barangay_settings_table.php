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
            $table->renameColumn('right_logo', 'poblacion_logo');
            $table->renameColumn('left_logo', 'barangay_logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangay_settings', function (Blueprint $table) {
            $table->renameColumn('poblacion_logo', 'right_logo');
            $table->renameColumn('barangay_logo', 'left_logo');
        });
    }
};
