<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsApiResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_api_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('messageId')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('recipient');
            $table->text('message');
            $table->string('messageParts')->nullable();
            $table->string('cost')->nullable();
            $table->string('status')->nullable();
            $table->string('statusCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_api_responses');
    }
}
