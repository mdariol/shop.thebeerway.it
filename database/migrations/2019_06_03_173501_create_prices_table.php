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
            $table->unsignedDecimal('horeca')->nullable();
            $table->unsignedDecimal('purchase');
            $table->unsignedDecimal('distribution')->nullable();

            $table->unsignedDecimal('discount')->nullable();
            $table->unsignedDecimal('margin')->nullable();
            $table->boolean('fixed_margin')->default(false);

            $table->unsignedBigInteger('beer_id');

            $table->timestamps();

            $table->foreign('beer_id')->references('id')->on('beers')
                ->onDelete('cascade');
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
