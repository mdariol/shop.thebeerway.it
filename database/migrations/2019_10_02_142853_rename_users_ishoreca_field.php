<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUsersIsHorecaField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('ishoreca')->default(false)->change();

            $table->renameColumn('ishoreca', 'is_horeca');

            $table->dropColumn(['horecaname', 'vatnumber']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_horeca', 'ishoreca');

            $table->string('horecaname')->nullable();
            $table->string('vatnumber')->nullable();
        });
    }
}
