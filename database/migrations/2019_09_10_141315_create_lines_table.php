<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('beer_id');
            $table->integer('qty')->nullable();
            $table->unsignedDecimal('unit_price')->nullable();
            $table->unsignedDecimal('price')->nullable();

            $table->foreign('order_id')->references('id')->on('orders')
                ->onDelete('set null');
            $table->foreign('beer_id')->references('id')->on('beers')
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
        Schema::dropIfExists('lines');
    }
}
