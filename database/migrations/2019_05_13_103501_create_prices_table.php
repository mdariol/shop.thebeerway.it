<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('beer_id');
            $table->integer('horeca_price')->nullable();
            $table->integer('horeca_unit_price')->nullable();
            $table->integer('purchase_price');
            $table->integer('purchase_unit_price');
            $table->float('purchase_discount')->nullable();
            $table->integer('distribution_price')->nullable();
            $table->integer('distribution_unit_price')->nullable();
            $table->float('distribution_margin')->nullable();
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
        Schema::dropIfExists('price');
    }
}
