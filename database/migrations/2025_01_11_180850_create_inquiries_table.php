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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->string('tel')->comment('電話番号');
            $table->string('zip_code', 7)->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->text('content')->comment('問合せ内容');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
