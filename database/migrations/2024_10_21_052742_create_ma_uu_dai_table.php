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
        Schema::create('ma_uu_dai', function (Blueprint $table) {
            $table->string('code',20)->primary();
            $table->string('mo_ta', 255);
            $table->tinyInteger('hinh_thuc')->default(1); //1: giảm VND, 2: giảm %
            $table->integer('gia_tri');
            $table->integer('so_luong');
            $table->dateTime('ngay_ket_thuc');
            $table->boolean('trang_thai')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_uu_dai');
    }
};
