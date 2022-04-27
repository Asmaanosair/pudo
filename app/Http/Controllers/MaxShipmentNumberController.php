<?php

namespace App\Http\Controllers;

use App\MaxShipmentNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaxShipmentNumberController extends Controller
{
    public  function edit(Request $request)
    {
        $user = auth()->user();

        $role= MaxShipmentNumber::find(1);
        return response()->json([compact('role')]);

    }
    public  function update(Request $request)
    {
        $validator = Validator::make($request->all(), [  //validate inputs
            'max_number' => 'required|numeric',

        ]);
        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
        $user = auth()->user();

        $rule= MaxShipmentNumber::find(1);
        $rule->max_number=$request->max_number;

        $rule->save();
        return response()->json([$rule]);

    }
}
