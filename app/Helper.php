<?php namespace App;

use App\City;

use App\Enums\AOrderStatus;

class Helper
{

    public static function getCityByPoint($points){
      return City::whereRaw("ST_Intersects(geom, ST_GeomFromEWKT('SRID=4326;POINT ($points)'))")->first();
    }


    public static function getByDistance($dist){
        return Order::whereRaw("ST_DWithin(
    ST_MakePoint(delivery_lng::double precision, delivery_lat::double precision)::geography,
    ST_MakePoint(46.81519534, 24.69224834)::geography,
    1000)")->get();
    }




    public static function AlmaraiCahngeOrderStatus($order_code,$status){
        $statusString = AOrderStatus::STATUS_STRING[$status];
        $data=[
            'OrderId'=>$order_code,
            'Status'=>$statusString,
            'RejectionReason'=>'',
            'ApiIdentity'=>'db3d2824-27ef-4723-b7f3-9ceba12e806a'

        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://staging-baqalaexpress.azurewebsites.net/api/driverCompany/changeOrderStatus");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/x-www-form-urlencoded"
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    public static function AlmaraiDriverAccepted($order_code,$driverId){
       $driver = Fleet::find($driverId);
        $data=[
            'OrderId'=>$order_code,
            'Driver.Id'=>$driverId,
            'Driver.MobileNumber'=>$driver->mobile,
            'Driver.CountryCode'=>'+966',
            'Driver.Username'=>$driver->code,
            'Driver.Email'=>$driver->code.'@pudo.com',
            'Driver.ArabicName'=>$driver->name,
            'Driver.EnglishName'=>$driver->name,
            'Driver.Latitude'=>'24.934826',
            'Driver.Longitude'=>'46.452311',
            'Driver.Rate'=>'5',
            'ApiIdentity'=>'db3d2824-27ef-4723-b7f3-9ceba12e806a'

        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://staging-baqalaexpress.azurewebsites.net/api/driverCompany/acceptOrder");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/x-www-form-urlencoded"
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public static function ChangeOrderStatus($url,$api,$order){
        $data=[
            'Order'=>$order,
            'api_key'=>$api
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/x-www-form-urlencoded"
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


}
