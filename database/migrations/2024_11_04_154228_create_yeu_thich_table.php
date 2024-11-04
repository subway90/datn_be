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
        Schema::create('yeu_thich', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tai_khoan_id')->index();
            $table->unsignedBigInteger('toa_nha_id')->index();
            $table->foreign('tai_khoan_id')->references('id')->on('users');
            $table->foreign('toa_nha_id')->references('id')->on('toa_nha');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_thich');
    }
};
