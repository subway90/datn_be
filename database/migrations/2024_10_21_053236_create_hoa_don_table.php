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
            Schema::create('hoa_don', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('hop_dong_id')->index();
                $table->integer('tien_thue');
                $table->integer('tien_dien');
                $table->integer('tien_nuoc');
                $table->integer('tien_xe');
                $table->integer('tien_dich_vu');
                $table->text('noi_dung')->nullable();
                $table->boolean('trang_thai')->default(0); //0: chưa thanh toán, 1: đã thanh toán
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('hop_dong_id')->references('id')->on('hop_dong')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('hoa_don');
        }
    };
