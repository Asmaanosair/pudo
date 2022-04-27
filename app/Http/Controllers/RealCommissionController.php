<?php

namespace App\Http\Controllers;

use App\City;
use App\Commission;
use App\RealCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RealCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $commissions = RealCommission::select('price_default AS default_price', 'real_commissions.*')->paginate($request->get('itemsLimit'));

        return response()->json(compact('commissions'));
    }
    public function create()
    {

        $cities = City::all()->where('active',1);


        return response()->json(compact('cities'));
    }







    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [  //validate inputs
            "name" => 'required',
            "type" => 'required',
            "price_default" => 'required',
            "price_after" => 'required',
            "city_id" => 'required',
            "distance" => 'required',
        ]);


        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
        $price=$request->price_after;
     if($request->type==0){
         $price = 0;
     }

        $commission=new RealCommission();
        $commission->distance=$request->distance;
        $commission->price_after=$price;
        $commission->city_id=$request->city_id;
        $commission->price_default=$request->price_default;
        $commission->type=$request->type;
        $commission->max_cost=$request->max_cost;
        $commission->name=$request->name;
        $commission->save();
        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $commission= RealCommission::find($id);
        return response()->json(compact('commission'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [  //validate inputs
            "name" => 'required',
            "type" => 'required',
//            "price_default" => 'required',
           // "price_after" => 'required',
            "city_id" => 'required',
//            "distance" => 'required',
        ]);

        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
        $price=$request->price_after;
        if($request->type==0){
            $price = 0;


        }
        $commision = RealCommission::find($id);
        $commision->distance=$request->distance;
        $commision->price_after=$price;
       // $commision->city_id=$request->city_id;
        $commision->price_default=$request->price_default;
        $commision->type=$request->type;
        $commision->name=$request->name;
        $commision->max_cost=$request->max_cost;
        $commision->save();

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $commision = RealCommission::find($id);
        $commision->delete();
        return response()->json(['status' => 'success']);
    }
}
