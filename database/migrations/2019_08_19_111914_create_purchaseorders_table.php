<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date')->nullable();
            $table->integer('number')->nullable();
            $table->unsignedBigInteger('brewery_id')->nullable();
            $table->foreign('brewery_id')->references('id')->on('breweries')
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
        Schema::dropIfExists('purchaseorders');
    }
}
