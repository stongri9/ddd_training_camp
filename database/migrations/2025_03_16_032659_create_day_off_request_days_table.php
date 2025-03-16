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
        Schema::create('day_off_request_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_off_request_id')->comment('休み希望ID');
            $table->date('date')->comment('休み希望日');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_off_request_days');
    }
};
