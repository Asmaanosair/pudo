<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;
use DB;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::paginate(20);
        $countries = Country::all();

        return response()->json(compact('cities','countries'));
    }


    public function store(Request $request)
    {

        $city  = new City();
        $city->name = $request->get('name');
        $city->geom = $request->get('geometry');
        $city->country_id = $request->get('countryId');
        $city->active = $request->get('active');
        $city->save();

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $city = City::find($id);
        return response()->json(['status' => 'success', 'city' => $city]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['geom'] = $request->geometry;
        $data['country_id'] = $request->countryId;
        $city = City::find($id);
        $city->update($data);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        return response()->json(['status' => 'success']);
    }

    public function changeActive(Request $request, $id)
    {
        $city = City::find($id);
        $city->active = $request->active;
        $city->save();
        return response()->json(['status' => 'success']);
    }
}
