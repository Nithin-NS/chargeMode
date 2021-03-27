<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterValue extends Model
{
    use HasFactory;
    protected $table='meter_values';
    protected $fillable=['Connector_ID','CP_ID','Date','Reservation_ID','Meter_Values'];
}
