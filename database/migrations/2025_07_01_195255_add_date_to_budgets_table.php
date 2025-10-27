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
    Schema::table('budgets', function (Blueprint $table) {
        $table->date('date')->nullable()->after('amount');
    });
}

public function down()
{
    Schema::table('budgets', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}

};
