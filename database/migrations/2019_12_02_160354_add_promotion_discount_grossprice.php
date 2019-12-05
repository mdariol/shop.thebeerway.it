<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionDiscountGrossprice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lines', function (Blueprint $table) {
            $table->unsignedDecimal('gross_price')->nullable();
            $table->unsignedDecimal('discount')->nullable();
            $table->bigInteger('promotion_id')->nullable();

            $table->foreign('promotion_id')->references('id')->on('promotions');

        });

        App\Line::whereNull('gross_price')
            ->update([
                "gross_price" => DB::raw("unit_price"),
            ]);

   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lines', function (Blueprint $table) {
            $table->dropColumn('gross_price');
            $table->dropColumn('discount');
            $table->dropColumn('promotion_id');
        });
    }
}
