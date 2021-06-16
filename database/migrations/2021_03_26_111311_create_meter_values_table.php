<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeterValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meter_values', function (Blueprint $table) {
            $table->id();
            $table->integer('Connector_ID');
            $table->integer('CP_ID');
            $table->string('Date');
            $table->string('Reservation_ID');
            $table->integer('Meter_Values');
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
        Schema::dropIfExists('meter_values');
    }
}
