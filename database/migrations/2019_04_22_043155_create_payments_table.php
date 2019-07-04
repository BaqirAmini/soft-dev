<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('inv_id')->unsigned();
            $table->string('payment_type', 128);
            // $table->integer('trans_code', 128)->nullable();
            $table->string('recieved_amount', 12,2);
            $table->string('recievable_amount', 12,2)->default(0);
            $table->foreign('inv_id')->references('inv_id')->on('invoices')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('payments');
    }
}
