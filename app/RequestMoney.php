<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestMoney extends Model
{
    protected $fillable=['status','note','balance'];

    public function fleet(){

        return $this->belongsTo(Fleet::class,'fleet_id');

    }
}
