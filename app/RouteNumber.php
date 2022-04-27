<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteNumber extends Model
{
    protected $fillable=['fleet_id','branch_id','status'];
    public function getPdfUrlAttribute($value){
        return config('image_s3.base_url').'Patches/'.$value;
    }
    public function notificationBatches()
    {
        return $this->belongsToMany(Fleet::class,'route_number_fleets','route_number_id','fleet_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
