<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('item_id');
            $table->integer('cust_id')->unsigned();
            $table->integer('ctg_id')->unsigned();
            $table->integer('sup_id')->unsigned();
            $table->foreign('cust_id')->references('cust_id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('ctg_id')->references('ctg_id')->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('sup_id')->references('supplier_id')->on('suppliers')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->string('item_name');
            $table->string('item_image')->default('item.png')->nullable();
            $table->decimal('unit_price', 12, 2);
            $table->integer('quantity');
            $table->integer('barcode_number')->nullable();
            $table->integer('discount')->nullable();
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
        Schema::dropIfExists('items');
    }
}
