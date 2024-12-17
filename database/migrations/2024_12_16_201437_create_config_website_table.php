<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_website', function (Blueprint $table) {
            $table->id(); // Tự động thêm trường ID
            $table->string('name', 255)->nullable(false); // Tên
            $table->text('description')->nullable(false); // Mô tả
            $table->string('favicon', 255)->nullable(false); // Favicon
            $table->string('logo', 255)->nullable(false); // Logo
            $table->string('phone', 10)->nullable(false); // Số điện thoại
            $table->string('email', 255)->nullable(false); // Email
            $table->text('address')->nullable(false); // Địa chỉ
            $table->timestamps(); // Trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_website');
    }
}
