<?php

namespace App\Http\Controllers;

use App\Commission;
use App\EndPoint;
use App\RealCommission;
use App\User;
use Ejarnutowski\LaravelApiKey\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = auth('api')->user();

        if($user->hasRole('admin')){
            return response()->json(['message' => 'created', 'user' => $user]);
        }
        $endpoint = EndPoint::where('client_id',$user->id)->get();
        $commissions = Commission::all();
        $realCommissions = RealCommission::all();
        $user->authKey = ApiKey::select('key')->where('name',$user->company_name)->first();
        return response()->json(['message' => 'created', 'user' => $user, 'commissions' => $commissions,'realCommissions'=>$realCommissions,'endpoint'=>$endpoint]);
    }

    public function me()
    {
        $user = auth('api')->user();
        return response()->json(['message' => 'created', 'user' => $user], 200);
    }

    public function editProfile(Request $request)
    {
        $user_id = auth('api')->user()->id;

        $user = User::find($user_id);
        ApiKey::where(['name' => $user->company_name])->update(['key' => $request->authKey]);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company_name = $request->company_name;

        if ($request->commission!="null") {
            $user->commission_id = $request->commission;
        }
        if ($request->realCommission!="null") {
            $user->real_commission_id = $request->realCommission;
        }
        $user->name = $request->name;
        $user->api_id = $request->api_id;
        $user->save();
        return response()->json(['message' => 'created', 'data' => $user], 200);
    }


    public function resetPassword(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $user = User::find($user_id);
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($new_password);
            $user->save();
            return response()->json(['message' => 'created', 'data' => $user], 200);
        } else {
            return response()->json(['message' => 'failed', 'data' => 'failed updated'], 404);
        }
    }
}
