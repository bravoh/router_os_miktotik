<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn("name","first_name");
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string("middle_name")->after("first_name")->nullable();
            $table->string("last_name")->after("middle_name")->nullable();
            $table->string("address")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn("first_name","name");
            $table->dropColumn("middle_name","last_name","address");
        });
    }
}
