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
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('abv')->nullable();
            $table->float('ibu')->nullable();
            $table->float('plato')->nullable();

            $table->unsignedInteger('color_id')->nullable();
            $table->unsignedInteger('brewery_id')->nullable();
            $table->unsignedInteger('packaging_id')->nullable();
            $table->unsignedInteger('style_id')->nullable();

            $table->timestamps();

            $table->foreign('color_id')->references('id')->on('colors')
                ->onDelete('set null');
            $table->foreign('style_id')->references('id')->on('styles')
                ->onDelete('set null');
            $table->foreign('packaging_id')->references('id')->on('packagings')
                ->onDelete('set null');
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
        Schema::dropIfExists('beers');
    }
}
