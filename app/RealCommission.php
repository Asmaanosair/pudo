<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealCommission extends Model
{
    protected $fillable=['name','city_id','price_default','price_after','distance','type'];
}
