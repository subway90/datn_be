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
            $table->unsignedBigInteger('hop_dong_id')->index();
            $table->string('code_uu_dai',20)->nullable();
            $table->boolean('hinh_thuc')->default(1);
            $table->string('ma_giao_dich',20);
            $table->integer('so_tien');
            $table->text('noi_dung')->nullable();
            $table->boolean('trang_thai')->default(0);
            $table->dateTime('ngay_giao_dich');
            $table->timestamps();
            $table->foreign('hop_dong_id')->references('id')->on('hop_dong');
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
