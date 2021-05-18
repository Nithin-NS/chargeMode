<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeChargingpointConnectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargepoint_connector', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'chargepoint_id')->constraint();
            $table->foreignId(column: 'connector_id')->constraint();
            $table->integer('status')->default(0)->comment('0-incactive, 1-active');
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
        Schema::dropIfExists('chargepoint_connector');
    }
}
