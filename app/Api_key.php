<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ejarnutowski\LaravelApiKey\Models\ApiKey;

class Api_key extends ApiKey
{

    protected $fillable=['name','key'];
}
