<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EndPoint extends Model
{
    protected $fillable=['endpoint','client_id'];
    public function user(){
        return $this->hasOne(User::class,'client_id');
    }
}
