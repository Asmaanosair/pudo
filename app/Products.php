<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable=[
        "order_id",
        "name",
        "one_piece_price",
        "quantity",
        "total_price",
        "note",

    ];

}
