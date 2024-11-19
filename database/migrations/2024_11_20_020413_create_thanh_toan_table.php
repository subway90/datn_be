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
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hoa_don_id')->index();
            $table->boolean('hinh_thuc')->default(0); //0: tiền mặt, 1: ví điện tử
            $table->string('code_uu_dai', 20)->nullable(); // mã ưu đãi giảm giá
            $table->string('ma_giao_dich', 20); //dùng để debug search ví điện tử
            $table->dateTime('ngay_giao_dich')->nullable();
            $table->integer('so_tien');
            $table->text('noi_dung')->nullable();
            $table->boolean('trang_thai')->default(0); //0: thất bại, 1: thành công
            $table->timestamps();
            $table->foreign('hoa_don_id')->references('id')->on('hoa_don')->onDelete('cascade');
            $table->foreign('code_uu_dai')->references('code')->on('ma_uu_dai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
    }
};
