<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable=[
        "os",
        "user_type",
        "player_id",
        "user_id"
    ];
}
