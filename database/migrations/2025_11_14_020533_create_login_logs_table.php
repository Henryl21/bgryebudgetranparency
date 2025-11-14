<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('login_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->unsignedBigInteger('officer_id')->nullable();
        $table->timestamp('time_in')->nullable();
        $table->timestamp('time_out')->nullable();
        $table->timestamps();

        // Foreign keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('officer_id')->references('id')->on('officer_users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('login_logs');
}
};
