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
            $table->unsignedBigInteger('id_phong')->index();
            $table->unsignedBigInteger('id_tai_khoan')->index();
            $table->dateTime('ngay_bat_dau');
            $table->dateTime('ngay_ket_thuc');
            $table->boolean('trang_thai')->default(0);
            $table->integer('gia_thue');
            $table->timestamps();
            $table->foreign('id_phong')->references('id')->on('phong');
            $table->foreign('id_tai_khoan')->references('id')->on('tai_khoan');
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
