<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable=['name','active'];
    public function City(){
        return $this->hasMany(City::class)->where('active','true');
    }
    public function fleet(){
        return $this->hasMany(Fleet::class,'country');
    }
}
