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
        Schema::create('dang_ky_nhan_tin', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('token_verify')->unique();
            $table->boolean('trang_thai')->default(0); //0: chưa xác thực, 1: đã xác thực
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_ky_nhan_tin');
    }
};
