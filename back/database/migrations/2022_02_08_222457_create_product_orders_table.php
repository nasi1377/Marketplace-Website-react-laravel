<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('product_id');
            $table->integer('price')->default(0);
            $table->integer('weight')->default(0);
            $table->integer('count')->default(1);
            $table->text('message_referred')->nullable();
            $table->enum('type', ['MAJOR', 'SINGLE'])->default('SINGLE');
            $table->enum('status', ['PENDING', 'PROCESSED', 'POSTED', 'DELIVERED', 'REFERRED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_orders');
    }
}
