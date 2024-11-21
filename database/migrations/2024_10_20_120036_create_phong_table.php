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
        Schema::create('phong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toa_nha_id');
            $table->string('ten_phong', 255);
            $table->text('hinh_anh');
            $table->integer('dien_tich');
            $table->boolean('gac_lung');
            $table->integer('gia_thue');
            $table->integer('don_gia_dien');
            $table->integer('don_gia_nuoc');
            $table->integer('tien_xe_may');
            $table->integer('phi_dich_vu');
            $table->string('tien_ich')->nullable();
            $table->string('noi_that')->nullable();
            $table->boolean('trang_thai')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('toa_nha_id')->references('id')->on('toa_nha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phong');
    }
};
