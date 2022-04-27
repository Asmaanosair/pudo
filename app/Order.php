<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
    protected $hidden=['pivot'];

    protected $fillable=[
        "code",
        "user_id",
        "order_status_id",
        "fleet_id",
        "number_of_products",
        "order_price",
        "discount",
        "pay_on_pickup",
        "collect_on_delivery",
        "deliver_fees",
        "total_price",
        "pick_up_lng",
        "pick_up_lat",
        "delivery_lng",
        "delivery_lat",
        "customer_name",
        "customer_mobile",
        "delivery_time",
        "picked_up_at",
        "delivered_at",
        "address",
        "city_id",
        "payment_method",
        "payment_type",
        "created_at",
        "updated_at",
        "kilos_total_price",
        "kilos_count",
        'commission',
        'balance_client',
      '  balance_fleet',
      'branch_id',
      'shipment_weight',

    ];

    public function getPdfUrlAttribute($value){
        return config('image_s3.base_url').'orderPatch/'.$value;
    }
    public function products(){
        return $this->hasMany(Products::class,'order_id');
    }
    public function patch(){
        return $this->belongsTo(RouteNumber::class,'route_number_id');
    }
    public function status(){
        return $this->belongsTo(OrderStatus::class,'order_status_id');
    }

    public function fleet(){
        return $this->belongsTo(Fleet::class,'fleet_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id')->with('Country');
    }
    public function getPickUpLngAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }
    public function getPickUpLatAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }
    public function getPaymentMethodAttribute($value)
    {
        if (is_string($value)) {
            return (int)$value;
        }
    }

        public function getTotalPriceAttribute($value){
            if(is_string($value)) {
                return (int)$value;
            }

    }
        public function getKilosCountAttribute($value){
            if(is_string($value)) {
                return (int)$value;
            }

    }
    public function getDeliveryLngAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }
    public function getDeliveryLatAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }
    public function getNumberOfProductsAttribute($value){
        if(is_string($value)) {
            return (int)$value;
        }
        return $value;
    }
//    public function getCreatedAtAttribute($date)
//    {
//        return Carbon::parse($date)->format('d-M-Y H:i:s');
//    }
    public function invoice(){
        return $this->hasMany(Invoice::class,'order_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
    public function branchWithCity(){
        return $this->belongsTo(Branch::class,'branch_id')->with('city');
    }
    public function notificationOrders()
    {
        return $this->belongsToMany(Fleet::class,'order_fleet','order_id','fleet_id');
    }
    public function fleetOrder($id)
    {
        return $this->belongsToMany(Fleet::class,'order_fleet','fleet_id')->where('fleet_id',$id);
    }
}
