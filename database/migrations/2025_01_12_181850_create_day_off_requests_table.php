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
        Schema::create('day_off_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->date('date')->comment('休み希望日');
            $table->primary(['user_id', 'date']); // 複合主キーを設定
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_off_requests');
    }
};
