<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable =['price','type','name','distance','price_more_kilo','type2','max_cost'];
}
