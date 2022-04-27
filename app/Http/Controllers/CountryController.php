<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $cities = Country::paginate(20);
        return response()->json(compact('cities'));
    }


    public function store(Request $request)
    {
        $city  = new Country();

        $city->name = $request->get('name');
        $city->active = $request->get('active');
        $city->geom= $request->get('geometry');
        $city->save();

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $city = Country::find($id);
        return response()->json(['status' => 'success', 'city' => $city]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $city = Country::find($id);
        $data['geom']=$request->geometry;
        $city->update($data);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $city = Country::find($id);
        $city->delete();
        return response()->json(['status' => 'success']);
    }
    public function changeActive(Request $request, $id)
    {
        $city = Country::find($id);
        $city->active = $request->active;
        $city->save();
        return response()->json(['status' => 'success']);
    }
}
