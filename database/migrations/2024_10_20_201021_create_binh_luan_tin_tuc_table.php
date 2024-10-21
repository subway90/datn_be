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
            $table->integer('id_tai_khoan')->nullable();
            $table->integer('id_bai_viet')->nullable();
            $table->text('noi_dung')->nullable();
            $table->string('trang_thai_binhluan')->nullable();
            $table->timestamps();
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
