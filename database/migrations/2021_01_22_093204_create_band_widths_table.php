<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandWidthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_widths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('download_rate');
            $table->string('download_rate_unit');
            $table->string('upload_rate');
            $table->string('upload_rate_unit');
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
        Schema::dropIfExists('band_widths');
    }
}
