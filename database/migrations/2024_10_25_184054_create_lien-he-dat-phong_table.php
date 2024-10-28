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
        Schema::create('lien-he-dat-phong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phong_id');
            $table->unsignedBigInteger('tai_khoan_id');
            $table->text('ho_ten');
            $table->string('so_dien_thoai');
            $table->text('noi_dung')->nullable();
            $table->boolean('trang_thai')->default(1);
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
        Schema::dropIfExists('lien-he-dat-phong');
    }
};
