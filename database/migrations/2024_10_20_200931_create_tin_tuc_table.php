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
        Schema::create('tin_tuc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tai_khoan')->index();
            $table->unsignedBigInteger('id_danh_muc')->index();
            $table->timestamps();
    
            $table->foreign('id_tai_khoan')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_danh_muc')->references('id')->on('danh_muc_tin_tuc')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tin_tuc');
    }
};
