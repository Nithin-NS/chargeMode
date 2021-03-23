<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConnectorType;
class ChargePoint extends Model
{
    protected $table='chargepoint';
    protected $primaryKey='CP_ID';
    protected $fillable=['CP_Name','CP_State','CP_District','CP_Loc','CP_Connector_Type','CB_Serial_No','CP_Serial_No','CP_Firmware_Ver','CP_Meter_Serial_No','CP_Meter_Type','Station_Phone','Station_Email','CP_Status'];
    public function getconnector()
    {
        return $this->belongsTo('App\Models\ConnectorType','CP_Connector_Type','id');
    }
}
