<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable=['name','manager_id','user_id','pickup_lat','pickup_lng','status','address','city_id'];

    public function client(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function manager(){
        return $this->belongsTo(User::class,'manager_id');
    }
    public function order(){
        return $this->hasMany(Order::class);
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id')->with('Country');
    }
}
