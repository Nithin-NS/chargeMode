<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('Connector_ID')->nullable();
            $table->integer('CP_ID')->nullable();
            $table->integer('CS_ID')->nullable();
            $table->string('User_ID')->nullable();
            $table->string('Reservation_ID')->nullable();
            $table->dateTime('Trans_DateTime')->nullable();
            $table->integer('Trans_Meter_Start')->nullable();
            $table->integer('Trans_Meter_Stop')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
