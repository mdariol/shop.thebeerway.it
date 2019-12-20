<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('action');
            $table->integer('quantity');
            $table->bigInteger('lot_id');
            $table->bigInteger('agent_id')->nullable();
            $table->timestamp('reverted_at')->nullable();

            $table->timestamps();

            $table->foreign('lot_id')->references('id')->on('lots')
                ->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')
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
        Schema::dropIfExists('movements');
    }
}
