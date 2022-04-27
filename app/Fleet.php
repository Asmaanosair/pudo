<?php

namespace App;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Fleet extends Authenticatable implements JWTSubject, Wallet, WalletFloat
{
    use Notifiable;
    use HasWalletFloat;

    protected $table='fleets';
    protected $primaryKey='id';

    protected $fillable = [
        "user_id",
        "code",
        "mobile",
        "name",
        "identity",
        "status",
        "image",
        "password",
        "gender",
        "lng",
        "lat",
        "verification_code",
        "complete",
        "vehicle_type",
        "nationality",
        "nationalityId",
        "job_type",
        "supplier_id",
        'active',
        "bank_name",
        "bank_iban",
        "contract_type",
        "age",
        "application_status_id",
        "uuid",
        "supplier_uuid",
        'device_token',
        "city_id",
        "country",
        "date_of_birth",
        "file_uploaded"



    ];



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $hidden = [
        'password'
    ];


    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function applicationStatus(){
        return $this->belongsTo(ApplicationStatus::class);
    }

    public function devices(){
        return $this->hasMany(Device::class,'user_id')->where('os','!=','Web');
    }

    public function files(){
        return $this->hasMany(FleetFile::class,'fleet_id');
    }
    public function user(){
        return $this->belongsTo(User::class,);
    }
    public function countryData(){
        return $this->belongsTo(Country::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function getLastLoginAttribute($value){
        if ($value != null)
        return Carbon::createFromTimeString($value)->diffForHumans();
    }
    public function getLngAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }
    public function getLatAttribute($value){
        if(is_string($value)) {
            return (float)$value;
        }
        return $value;
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function newOrders()
    {
        return $this->belongsToMany(Order::class,'order_fleet','fleet_id','order_id');
    }
    public function newPatches()
    {
        return $this->belongsToMany(RouteNumber::class,'route_number_fleets','fleet_id','route_number_id')->with('branch');
    }

    protected $guard_name = 'fleet';
}
