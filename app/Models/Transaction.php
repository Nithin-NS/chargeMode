<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable=['Connector_ID','CP_ID','CS_ID','User_ID','Reservation_ID','Trans_DateTime','Trans_Meter_Start','Trans_Meter_Stop'];
}
