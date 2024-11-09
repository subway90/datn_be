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
        Schema::create('toa_nha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('khu_vuc_id');
            $table->string('slug', length: 255);
            $table->string('ten', 255);
            $table->text('image');
            $table->text('mo_ta');  
            $table->string('tien_ich',255);
            $table->text('vi_tri');
            $table->integer('gia_thue');
            $table->boolean('noi_bat')->default(0);
            $table->integer('luot_xem')->default(0);
            $table->timestamps();
            $table->foreign('khu_vuc_id')->references('id')->on('khu_vuc');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toa_nha');
    }
};
