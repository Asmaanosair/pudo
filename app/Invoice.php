<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function getFilePathAttribute($value){
        return config('image_s3.base_url').'fleets/'.$value;
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
