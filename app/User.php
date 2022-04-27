<?php

namespace App;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject , Wallet, WalletFloat
{
    use HasWalletFloat;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function devices(){
        return $this->hasMany(Device::class,'user_id')->where('os','Web');
    }

    protected $guard_name = 'api';
    public function files(){
        return $this->hasMany(UserFile::class,'user_id');
    }
    public function userStatus(){
        return $this->belongsTo(UserStatus::class);
    }
    public function endpoint(){
        return $this->hasOne(EndPoint::class,'client_id');
    }
    public function fleet(){
        return $this->hasMany(Fleet::class,'user_id');
    }
    public function cityData(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function supplierCommission(){
        return $this->belongsTo(RealCommission::class,'real_commission_id');
    }

}
