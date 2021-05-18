<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargepiontConnector extends Model
{
    use HasFactory;
    protected $table='chargepoint_connector';
    protected $fillable=['chargepoint_id','connector_id','status'];
}
