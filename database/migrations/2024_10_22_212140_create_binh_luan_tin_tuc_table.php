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
            $table->unsignedBigInteger('tai_khoan_id');
            $table->unsignedBigInteger('tin_tuc_id');
            $table->text('noi_dung');
            $table->boolean('trang_thai')->default(1);
            $table->timestamps();
            $table->foreign('tai_khoan_id')->references('id')->on('users');
            $table->foreign('tin_tuc_id')->references('id')->on('tin_tuc');
            $table->softDeletes();
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
