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
        Schema::create('binh_luan_toa_nha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tai_khoan_id');
            $table->unsignedBigInteger('toa_nha_id');
            $table->text('noi_dung');
            $table->boolean('trang_thai')->default(0); //(0: chưa duyệt, 1: đã duyệt)
            $table->timestamps();
            $table->foreign('tai_khoan_id')->references('id')->on('users');
            $table->foreign('toa_nha_id')->references('id')->on('toa_nha');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binh_luan_toa_nha');
    }
};
