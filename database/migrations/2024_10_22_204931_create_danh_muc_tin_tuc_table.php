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
        Schema::create('danh_muc_tin_tuc', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc');
            $table->string('slug');
            $table->boolean('trang_thai')->default(1);
            $table->integer('thu_tu')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_muc_tin_tuc');
    }
};