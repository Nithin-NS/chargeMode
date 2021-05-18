<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Connector;

class ChargePoint extends Model
{
    protected $table='chargepoints';
    protected $primaryKey='CP_ID';
    protected $fillable=['CP_Name','CP_State','CP_District','CP_Loc','CP_Connector_Type','CB_Serial_No','CP_Serial_No','CP_Firmware_Ver','CP_Meter_Serial_No','CP_Meter_Type','Station_Phone','Station_Email','CP_Status','created_at','updated_at'];
    
    public function connectors()
    {
        return $this->belongsToMany(Connector::class, 'chargepoint_connector', 'chargepoint_id', 'connector_id');
    }
}
