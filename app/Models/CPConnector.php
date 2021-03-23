<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CPConnector extends Model
{
    protected $table='cp_connector';
    protected $fillable=['cp_id','connector_type','status'];

}
