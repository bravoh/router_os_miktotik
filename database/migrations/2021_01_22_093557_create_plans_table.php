<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('price');
            $table->string('type');//Hotspot or PPPoE
            $table->string('limit_type')->nullable();//Limited, Ulimited
            $table->string('time_limit')->default(0);
            $table->string('time_limit_unit')->nullable();//Hrs, Mts
            $table->string('data_limit')->default(0);
            $table->string('data_limit_unit')->nullable();//Mb, Kb
            $table->unsignedBigInteger('bandwidth_id');
            $table->unsignedBigInteger('router_id')->nullable();
            $table->string('shared_users')->nullable();
            $table->integer('validity')->default(1);
            $table->string('validity_unit');//Days, Months
            $table->timestamps();

            $table->foreign('bandwidth_id')
                ->references('id')
                ->on('band_widths')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('router_id')
                ->references('id')
                ->on('routers')
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
        Schema::dropIfExists('plans');
    }
}
