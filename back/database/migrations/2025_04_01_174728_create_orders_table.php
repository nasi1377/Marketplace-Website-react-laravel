<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ارتباط با کاربر
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // ارتباط با محصول
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // اطلاعات سفارش
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);

            // وضعیت سفارش (0: لغو شده، 1: در انتظار پرداخت، 2: پرداخت شده، 3: در حال آماده‌سازی، 4: ارسال شده، 5: تحویل داده شده)
            $table->tinyInteger('status')->default(1);

            // اطلاعات پرداخت
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();

            // اطلاعات تحویل
            $table->text('delivery_address')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
            $table->softDeletes(); // برای حذف نرم افزاری
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
