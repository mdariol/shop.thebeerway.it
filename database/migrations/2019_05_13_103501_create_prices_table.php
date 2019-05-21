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
            $table->integer('horeca')->nullable();
            $table->integer('horeca_unit')->nullable();
            $table->integer('purchase');
            $table->integer('purchase_unit');
            $table->float('discount')->nullable();
            $table->integer('distribution')->nullable();
            $table->integer('distribution_unit')->nullable();
            $table->float('margin')->nullable();
            $table->boolean('fixed_margin')->default(false);
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
