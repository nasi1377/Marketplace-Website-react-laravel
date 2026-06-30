<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReturnedTable extends Migration
{
    public function up()
    {
        Schema::create('product_returned', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->integer('author_id')->nullable();
            $table->integer('product_id')->nullable(); // Product ID
            $table->integer('weight')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('product_order_id')->nullable(); 
            $table->longText('return_message')->nullable(); // Return message
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_returned');
    }
}
