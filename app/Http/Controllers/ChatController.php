<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Fleet;
use App\Notifications\NotifyChat;
use Illuminate\Http\Request;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger ;

class ChatController extends Controller
{
    //==================================== Start Get All Chat =======================================

    public function getAllChat()
    {

        try {
            $user_id = auth('api')->user()->id;
            $chats = Chat::where(function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id);
            })->orWhere(function ($query) use ($user_id) {
                $query->where('friend_id', '=', $user_id);
            })->get();

            if ($chats) {
                return response()->json([
                    'code' => '1',
                    'status' => 'success',
                    'data' => $chats
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
    //==================================== Start Get Chat =======================================

    public function getChat($friend_id)
    {

        try {
            $user = auth('api')->user();
            $user_id = $user->uuid;
            $chats = Chat::where(function ($query) use ($user_id, $friend_id) {
                $query->where('user_id', '=', $user_id)->where('friend_id', '=', $friend_id);
            })->orWhere(function ($query) use ($user_id, $friend_id) {
                $query->where('user_id', '=', $friend_id)->where('friend_id', '=', $user_id);
            })->get();


            if ($chats) {
                return response()->json([
                    'code' => '1',
                    'status' => 'success',
                    'data' => compact('chats', 'user')
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


    //==================================== Start Send Chat =======================================

    public function sendChat(Request $request)
    {

        try {

            // $reciever = Fleet::find($request->friend_id);

            // $reciever->notify(new NotifyChat($request->user_id,$request->chat ));

            $chat = Chat::create([
                'user_id' => $request->user_id,
                'friend_id' => $request->friend_id,
                'chat' => $request->chat
            ]);
            if ($chat) {
                return response()->json([
                    'code' => '1',
                    'status' => 'success',
                    'data' => $chat
                ], 201);
            }
            return response()->json([
                'code' => '0',
                'status' => 'error',
                'error_message' => 'chat not saved'
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'code' => '0',
                'status' => 'failed',
                'data' => ['message' => $exception->getMessage()],

            ], 500);
        }
    }

}
