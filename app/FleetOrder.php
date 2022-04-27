<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FleetOrder extends Model
{
    protected $fillable=[

        'fleet_id' ,  'order_id'
    ];
    protected $table='order_fleet';
}
