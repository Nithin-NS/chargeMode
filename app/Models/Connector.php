<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChargePoint;

class Connector extends Model
{
    protected $table = 'connectors';
    protected $fillable=['Type','Remarks'];
    // protected $guarded = ['id'];

    public function chargepoints()
    {
        return $this->belongsToMany(ChargePoint::class, 'chargepoint_connector', 'connector_id', 'chargepoint_id');
    }
}
