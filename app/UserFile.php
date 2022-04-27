<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function getFilePathAttribute($value){
        return config('image_s3.base_url').'supplier/'.$value;
    }
}
