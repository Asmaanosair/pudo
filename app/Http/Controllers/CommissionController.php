<?php

namespace App\Http\Controllers;

use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Commission::where('id','!=',0);

        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }
        // if ($request->has('sorter')) {
        //     $sorter = json_decode($request->sorter);
        //     $by = $sorter->asc == true ? 'ASC' : 'DESC';
        //     $column = $sorter->column;
        //     $query->orderBy($column, $by);
        // }
        $commissions  = $query->paginate($request->get('itemsLimit'));
        return response()->json(compact('commissions'));
    }


    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [  //validate inputs
            "name" => 'required',
            "type" => 'required',
            "price" => 'required',

        ]);

        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }

        $data = $request->all();
        $data['price_more_kilo']=0;
        $data['distance']=0;
        $data['type2']='Route';

        Commission::create($data);

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $commission= Commission::find($id);
        return response()->json(compact('commission'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [  //validate inputs
            "name" => 'required',
            "type" => 'required',
            "price" => 'required',

        ]);

        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
        $commision = Commission::find($id);
        $data = $request->all();
        $commision->update($data);

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $commision = Commission::find($id);
        $commision->delete();
        return response()->json(['status' => 'success']);
    }
}
