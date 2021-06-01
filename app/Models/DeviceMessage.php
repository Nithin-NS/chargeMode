<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceMessage extends Model
{
    use HasFactory;
    protected $table = 'device_messages';
    protected $fillable=['date','station','type','message'];
}
