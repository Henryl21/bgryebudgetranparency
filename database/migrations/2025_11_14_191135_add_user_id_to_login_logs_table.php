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
    Schema::table('login_logs', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable(); // nullable if optional
        $table->foreign('user_id')->references('id')->on('users'); // optional FK
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            //
        });
    }
};
