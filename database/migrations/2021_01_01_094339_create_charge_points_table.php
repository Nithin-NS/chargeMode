<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargepoint', function (Blueprint $table) {
            $table->increments('CP_ID');
            $table->string('CP_Name');
            $table->string('CP_State');
            $table->string('CP_District');
            $table->float('CP_Loc');
            //$table->integer('CP_Connector_Type');
            $table->string('CB_Serial_No');
            $table->string('CP_Serial_No');
            $table->string('CP_Firmware_Ver');
            $table->string('CP_Meter_Serial_No');
            $table->string('CP_Meter_Type');
            $table->string('Station_Phone');
            $table->string('Station_Email');
            //$table->integer('CP_Status');
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
        Schema::dropIfExists('charging_points');
    }
}
