<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('company_default_shipping_address', 'billing_profile_default_shipping_address');
        Schema::rename('user_default_company', 'user_default_billing_profile');
        Schema::rename('company_has_users', 'billing_profile_has_users');
        Schema::rename('companies', 'billing_profiles');

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('company_id', 'billing_profile_id');
        });

        Schema::table('billing_profile_default_shipping_address', function(Blueprint $table) {
            $table->renameColumn('company_id', 'billing_profile_id');
        });

        Schema::table('user_default_billing_profile', function (Blueprint $table) {
            $table->renameColumn('company_id', 'billing_profile_id');
        });

        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->renameColumn('company_id', 'billing_profile_id');
        });

        Schema::table('billing_profile_has_users', function (Blueprint $table) {
            $table->renameColumn('company_id', 'billing_profile_id');
        });

        Schema::table('billing_profiles', function (Blueprint $table) {
            $table->boolean('legal_person')->default(false);

            $table->renameColumn('business_name', 'name');
            $table->unique('vat_number');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('billing_profile_default_shipping_address', 'company_default_shipping_address');
        Schema::rename('user_default_billing_profile', 'user_default_company');
        Schema::rename('billing_profile_has_users', 'company_has_users');
        Schema::rename('billing_profiles', 'companies');

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('billing_profile_id', 'company_id');
        });

        Schema::table('company_default_shipping_address', function (Blueprint $table) {
            $table->renameColumn('billing_profile_id', 'company_id');
        });

        Schema::table('user_default_company', function (Blueprint $table) {
            $table->renameColumn('billing_profile_id', 'company_id');
        });

        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->renameColumn('billing_profile_id', 'company_id');
        });

        Schema::table('company_has_users', function (Blueprint $table) {
            $table->renameColumn('billing_profile_id', 'company_id');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('legal_person');

            $table->renameColumn('name', 'business_name');
            $table->dropUnique('billing_profiles_vat_number_unique');
        });

    }
}
