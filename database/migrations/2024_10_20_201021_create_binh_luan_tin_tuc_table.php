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
        Schema::create('binh_luan_tin_tuc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tai_khoan');
            $table->unsignedBigInteger('id_bai_viet');
            $table->text('noi_dung')->nullable();
            $table->string('trang_thai')->nullable();
            $table->timestamps();

            $table->foreign('id_tai_khoan')->references('id')->on('user');
            $table->foreign('id_bai_viet')->references('id')->on('tin_tuc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binh_luan_tin_tuc');
    }
};
