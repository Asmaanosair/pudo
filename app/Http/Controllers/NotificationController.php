<?php

namespace App\Http\Controllers;

use App\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function get()
    {

        try {
            $user = auth('api')->user();

            $notifications =  Notification::where([
                'notifiable_id' => $user->id,
                'notifiable_type' => 'App\User',
                'read_at' => Null
            ])->orderBy('created_at', 'desc')->get();


            if ($notifications) {
                return response()->json([
                    'code' => '1',
                    'status' => 'success',
                    'data' => compact('notifications','user')
                ], 201);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'code' => '0',
                'status' => 'failed',
                'data' => ['message' => $exception->getMessage()],

            ], 500);
        }
    }

    public function read(Request $request)
    {
        $user = auth('api')->user();
        $user->unreadNotifications->where('id', $request->id)->markAsRead();
        return 'success';
    }
}
