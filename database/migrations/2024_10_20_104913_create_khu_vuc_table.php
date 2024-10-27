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
        Schema::create('khu_vuc', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 255);
            $table->string('image', 255)->nullable();
            $table->string('slug', 255);
            $table->boolean('noi_bat')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khu_vuc');
    }
};
