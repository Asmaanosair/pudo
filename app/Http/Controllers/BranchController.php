<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Client;
use App\Helper;
use App\User;
use App\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    // user_id is the id of client
    // manager_id is the id of Manager Of branch
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $query = Branch::with('client');
        if ($user->menuroles == 'client') {
            $query->where('user_id', $user->id);
        } else if ($user->menuroles == 'client-branch') {
            $query->where('manager_id', $user->id);
        }
        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'created_at' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $branches = $query->paginate($request->get('itemsLimit'));
        return response()->json(compact('branches'));
    }

    public function branches(Request $request)
    {
        $user = auth('api')->user();
        $user_id=$request->client_id;
        if($user->menuroles == 'client'){
            $user_id=$user->id;
        }
        $branches = Branch::all()->where('user_id', $user_id);
        return response()->json(compact('branches'));
    }
    public function manager(Request $request)
    {
        $user = auth('api')->user();
        $id=$request->client;
        $manager = Client::join('users', 'users.id', '=', 'clients.user_id');
        if ($user->menuroles == 'client') {
            $id=$user->id;
        }
        $managers=$manager->where(['clients.admin_id' =>$id])->get();

        return response()->json(compact('managers'));
    }

    public function branch(Request $request, $id)
    {

        $user = auth('api')->user();

        $query = Branch::where("user_id", $id);

        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'created_at' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $branches = $query->paginate($request->get('itemsLimit'));


        return response()->json(compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth('api')->user();
        $statuses = UserStatus::all();
        $show=true;

        if ($user->menuroles != 'client') {
            $clients = User::where('menuroles', 'client')->get();
            return response()->json(compact('clients', 'statuses', 'show'));
        }else{
            $show=false;
            $clients=[];
            return response()->json(compact( 'clients','statuses', 'show'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        $client=[];
        $data = $request->all();

        if ($user->menuroles == 'client') {
            $data['user_id'] = auth('api')->user()->id;
            $client=['required'];
        }
        $validator = Validator::make($data, [  //validate inputs
            "manager_id" => 'required',
            "name" => 'required',
            "user_id" => $client,
            "pickup_lat" => 'required',
            "pickup_lng" => 'required',
            "address" => 'required',
            "status" => 'required',
        ]);
        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
        $city = Helper::getCityByPoint($data['pickup_lng'] . ' ' . $data['pickup_lat']);

        if (!isset($city->id)) {
            return response()->json(['message' => ['time' => ['the location of Pickup not Valid']]], 400);
        }
        $data['city_id'] = $city->id;
           $data= Branch::create($data);

            return response()->json(['status' => 'success']);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        $user = auth('api')->user();
        $statuses = UserStatus::all();
        return response()->json(compact('branch', 'user', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);
        $user = auth('api')->user();
        $branch->name = $request->name;
        $branch->pickup_lng = $request->pickup_lng;
        $branch->pickup_lat = $request->pickup_lat;
        $branch->status = $request->status;
        $branch->address = $request->address;
        $branch->manager_id = $request->manager_id;
        if ($user->menuroles == 'client') {
            $branch->user_id = $user->id;
        } else {
            $branch->user_id = $request->user_id;
        }
        $city = Helper::getCityByPoint($request->pickup_lng . ' ' . $request->pickup_lat);

        if (!isset($city->id)) {
            return response()->json(['message' => ['time' => ['the location of Pickup not Valid']]], 400);
        }
        $branch->city_id = $city->id;

        $branch->save();
        return response()->json(['status' => 'success']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return response()->json(['status' => 'success']);
    }
}
