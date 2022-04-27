<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=['country_id','geom','name','active'];
    public function Country(){
        return $this->belongsTo(Country::class);
    }
    public function fleet(){
        return $this->belongsTo(Fleet::class,'city_id');
    }
}
