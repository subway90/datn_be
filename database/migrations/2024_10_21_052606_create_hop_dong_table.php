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
        Schema::create('hop_dong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phong_id')->index();
            $table->unsignedBigInteger('tai_khoan_id')->index();
            $table->string('file_hop_dong')->nullable();
            $table->tinyInteger('so_luong_xe')->nullable();
            $table->tinyInteger('so_luong_nguoi')->nullable();
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->timestamps();
            $table->foreign('phong_id')->references('id')->on('phong');
            $table->foreign('tai_khoan_id')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hop_dong');
    }
};
