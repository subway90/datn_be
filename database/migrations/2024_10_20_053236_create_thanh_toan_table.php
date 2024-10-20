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
            $table->string('token', 10)->primary()->unique();
            $table->unsignedBigInteger('id_hop_dong')->index();
            $table->integer('code')->index();
            $table->integer('so_tien');
            $table->boolean('hinh_thuc')->default(1);
            $table->string('ma_giao_dich', 20);
            $table->boolean('trang_thai')->default(0);
            $table->$table->timestamps();
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
