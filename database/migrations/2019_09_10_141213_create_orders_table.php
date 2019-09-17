<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date')->nullable();
            $table->integer('number')->nullable();
            $table->string('status')->nullable();
            $table->string('deliverynote')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('shipping_address_id');
            $table->unsignedDecimal('total_amount')->nullable();


            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('set null');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses')
                ->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
