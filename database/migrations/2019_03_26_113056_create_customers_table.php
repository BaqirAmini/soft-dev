<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('cust_id');
            $table->string('cust_name');
            $table->string('cust_lastname')->nullable();
            $table->string('cust_photo')->default('customer.png')->nullable();
            $table->string('cust_phone');
            $table->string('cust_email')->index('cust_email')->nullable();
            $table->string('cust_state');
            $table->string('cust_addr');
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
        Schema::dropIfExists('customers');
    }
}
