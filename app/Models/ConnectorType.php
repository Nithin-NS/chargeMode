<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectorType extends Model
{
    protected $table = 'connectortype';
    protected $fillable=['Type','Remarks'];
    protected $guarded = ['id'];
}
