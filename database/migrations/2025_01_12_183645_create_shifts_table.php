<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 仮です！！！！
     */
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement()->comment('ID');
            $table->date('date')->comment('勤務日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
