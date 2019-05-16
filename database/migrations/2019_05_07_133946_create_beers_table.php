<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->float('abv');
            $table->float('ibu');
            $table->float('plato');

            $table->unsignedInteger('brewery_id');
            $table->unsignedInteger('packaging_id');
            $table->unsignedInteger('style_id')->nullable();

            $table->timestamps();

            $table->foreign('style_id')->references('id')->on('styles')
                ->onDelete('set null');
            $table->foreign('packaging_id')->references('id')->on('packagings')
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
        Schema::dropIfExists('beers');
    }
}
