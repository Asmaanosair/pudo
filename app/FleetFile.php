<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FleetFile extends Model
{

    public function getFilePathAttribute($value){
        return config('image_s3.base_url').'fleets/'.$value;
    }
    public function fleet(){
        return $this->belongsTo(Fleet::class,'fleet_id');
    }
    protected $fillable=[

     'iqama' ,  'vehicle_image','driving_license','file_path','fleet_id'
    ];
    public function getIqamaAttribute($value)
    {
        return url($value);
    }
    public function getDrivingLicenseAttribute($value)
    {
        return url($value);
    }
    public function getVehicleImageAttribute($value)
    {
        return url($value);
    }
}
