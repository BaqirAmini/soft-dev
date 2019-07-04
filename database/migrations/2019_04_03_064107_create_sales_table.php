<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->integer('cust_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->decimal('tax',12, 2)->nullable();
            $table->decimal('net_price',12, 2);
            $table->decimal('total',12, 2);
            $table->foreign('item_id')->references('item_id')->on('items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('cust_id')->references('cust_id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('sales');
    }
}
