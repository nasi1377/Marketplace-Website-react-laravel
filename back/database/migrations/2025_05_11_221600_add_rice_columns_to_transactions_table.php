<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiceColumnsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('rice_amount')->nullable()->after('value'); // مقدار برنج (کیلوگرم مثلاً)
            $table->unsignedBigInteger('id_rice')->nullable()->after('rice_amount'); // ID محصول برنج
        });
    }
    
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('rice_amount');
            $table->dropColumn('id_rice');
        });
    }
}
