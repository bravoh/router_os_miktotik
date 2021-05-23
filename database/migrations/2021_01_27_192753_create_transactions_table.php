<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->string('mode');//Mpesa, Cash
            $table->string('ref');
            $table->string('trx_code')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->unsignedBigInteger('plan_id');
            $table->string('plan_name');
            $table->string('ssid');
            $table->string('status')->nullable()->default('completed');
            $table->dateTime('date');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
