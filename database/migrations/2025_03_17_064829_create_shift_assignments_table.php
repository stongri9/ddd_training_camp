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
        Schema::create('shift_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id')->comment('シフトID');
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->string('shift_type')->comment('シフト種別');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_assignments');
    }
};
