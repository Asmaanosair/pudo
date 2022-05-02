<?php

namespace App\Http\Controllers\Driver;

use App\Branch;
use App\Enums\DriverApply;
use App\Events\NewBatch;
use App\Events\NewOrder;
use App\Fleet;
use App\FleetOrder;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Notifications\OrderNotification;
use App\Order;
use App\RouteNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use DB;




class FCMController extends Controller
{
    public function saveToken(Request $request)
    {
        auth('fleet')->user()->update(['device_token'=>$request->device_token]);
        return response()->json([
            'code' => '1',
            'status' => 'success',
        ], 200);
    }
    public function SendSignalNotification($tokens,$message)
    {
        $rest_api_key=Config::get("onesignal.rest_api_key");
        $app_id=Config::get("onesignal.app_id");
        $user_auth_key=Config::get("onesignal.user_auth_key");
        $android_channel_id=Config::get("onesignal.android_channel_id");

        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => $app_id,
            'include_player_ids' => $tokens,
            'contents' => $content,
            'android_channel_id'=>$android_channel_id
        );

        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        // print($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic '."$rest_api_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);;

        return $response;
    }

    public function sendNotification($token_id ,$body ,$title)
    {

        $registration_ids =$token_id;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registration_ids,
            'notification' => array("body" => $body,'title'=>$title,"sound"=> "sonic.mp3",
        "priority"=>"high" )
        );
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . "",
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        curl_close($ch);
        // echo  $result;
//        dd($result);

        return $result;

    }
    public function distance($lat,$lng,$distance)
    {

        $fleets = DB::table('fleets')
            ->whereNotNull('device_token')
            ->selectRaw("id, lat, lng ,device_token,
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( lat ) )
                       * cos( radians( lng ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( lat ) ) )
                      ) AS distance", [$lat, $lng, $lat])
            ->where('active', '=', 1)
            ->whereIn('status', ['online', 'free'])
            ->where('application_status_id', '=', DriverApply::APPROVED_BY_PUDO)
            ->havingRaw("( 6371 * acos( cos( radians($lat) ) *
                       cos( radians( lat ) )
                       * cos( radians( lng ) - radians($lng)
                       ) + sin( radians($lat) ) *
                       sin( radians( lat ) ) )
                      )<". $distance)
            ->groupBy('fleets.id')
            ->orderBy("distance",'asc')
            ->limit(10)->get();
                return $fleets;

    }
    public function assignOrder($arrayOrders,$branchId,$routNumberId,$distance)
    {

        $branch=Branch::find($branchId);
        $routNumber=RouteNumber::with('branch')->find($routNumberId);
        $fleet= $this->distance($branch->pickup_lat,$branch->pickup_lng,$distance);
        $driver_id=[];
        $tokens=[];

        if($fleet->toArray()!=[]) {
            foreach ($fleet as $row) {
                array_push($tokens, $row->device_token);
                array_push($driver_id, $row->id);
            }
            $message="New Batch";
            $this->SendSignalNotification($tokens,$message);
            if ($driver_id != []) {
                $routNumber->notificationBatches()->syncWithoutDetaching($driver_id);
            }

            foreach ($arrayOrders as $orderId) {
                $order = Order::with('user', 'status')->whereId($orderId->id)->first();
                $order = $order->makeHidden(['balance_client', 'balance_fleet', 'reason', 'fleet_id', 'picked_up_at', 'delivered_at', 'city_id', 'deleted_at']);
                if ($driver_id != []) {

                    $orders = Order::find($order->id);

                    $orders->notificationOrders()->syncWithoutDetaching($driver_id);
                }
                event(new NewOrder($order, $driver_id));
            }
           event(new NewBatch($routNumber,$driver_id));
        }

    }
}
