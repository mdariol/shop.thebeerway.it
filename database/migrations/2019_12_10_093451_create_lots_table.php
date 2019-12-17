<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('number');
            $table->bigInteger('beer_id');

            $table->integer('stock')->default(0);
            $table->integer('reserved')->default(0);

            $table->timestamp('bottled_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->foreign('beer_id')->references('id')->on('beers')
                ->onDelete('cascade');

            $table->unique(['number', 'beer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
