<?php

namespace App\Http\Controllers;

use App\Client;
use App\Commission;
use App\EndPoint;
use App\Fleet;
use App\User;
use App\UserFile;
use App\UserStatus;
use Ejarnutowski\LaravelApiKey\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $statuses = UserStatus::all();
        $query = User::with('files')->whereIn('menuroles', ['client']);

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
        $fleets = $query->paginate($request->get('itemsLimit'));
        foreach ($fleets as $fleet) {
            $balance = $fleet->balanceFloat;
            $fleet['fleet_balance'] = $balance;
        }


        return response()->json(compact('fleets', 'statuses'));
    }

    public function show($id)
    {
        $fleet = User::with('files', 'endpoint')->whereId($id)->first();

        return response()->json(compact('fleet'));
    }

    public function create()
    {
        $statuses = UserStatus::all();
        $commissions = Commission::all();
        return response()->json(['status' => $statuses, 'commissions' => $commissions], 200);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $validator = Validator::make($request->all(), [  //validate inputs
            "phone" => 'required',
            "name" => 'required|min:6|max:40',
            "email" => 'required|email|unique:users',
            "address" => 'required|min:5',
            "city_id" => 'required',
            "status" => 'required',
            "commission" => 'required',
            "company_name" => 'required|min:3|max:20',
            "password" => 'required|min:8'
        ]);


        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => $validator->errors()], 402);
        }


        $fleet = new User();
        $fleet->phone = $request->get('phone');
        $fleet->company_name = $request->get('company_name');
        $fleet->status = $request->get('status');
        $fleet->email = $request->get('email');
        $fleet->name = $request->get('name');
        $fleet->address = $request->get('address');
        $fleet->city_id = $request->get('city_id');
        $fleet->commission_id = $request->get('commission');
        $fleet->api_id = $request->get('api_id');
        $fleet->uuid = $request->get('api_id');
        $fleet->menuroles = 'client';
        $fleet->password = bcrypt($request->get('password'));
        $fleet->save();
        $fleet->assignRole('user');
        $api_key = new ApiKey();
        $api_key->name = $request->get('company_name');
        $api_key->key = Str::random(64);
        $api_key->active = 1;
        $api_key->save();
        $endpoint = new EndPoint();
        $endpoint->endpoint = "example.com";
        $endpoint->client_id = $fleet->id;
        $endpoint->save();

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $fleet = User::with('files')->whereId($id)->first();
        $statuses = UserStatus::all();
        $commissions = Commission::all();
        return response()->json(compact('fleet', 'statuses', 'commissions'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [  //validate inputs
            "phone" => 'required|min:10|max:20',
            "name" => 'required|min:6|max:40',
            "email" => 'required|email',
            "address" => 'required|min:5',
            "city" => 'required|min:2',
            "status" => 'required',
            "commission" => 'required',
            "company_name" => 'required|min:3|max:20',

        ]);

        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }

        $fleet = User::find($id);
        $fleet->phone = $request->get('phone');
        $fleet->company_name = $request->get('company_name');
        $fleet->status = $request->get('status');
        $fleet->email = $request->get('email');
        $fleet->name = $request->get('name');
        $fleet->address = $request->get('address');
        $fleet->city = $request->get('city');
        $fleet->uuid = $request->get('uuid');
        $fleet->commission_id = $request->get('commission');
        $fleet->save();
        $fleet->assignRole('user');
        return response()->json(['status' => 'success']);
    }


    public function addFiles($id, Request $request)
    {

        $image = $request->file('file');
        $ext = $request->file('file')->getClientOriginalExtension();
        $path = '/supplier';
        $rand = rand(1, 999999);
        $date = Date('ymdhis');
        $image_name = $rand . $date . '.' . $ext;
        $filePathLarge = Image::make($image->getRealPath())->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        });
        $filePathLargeResource = $filePathLarge->stream()->detach();
        $s3 = Storage::disk('s3');
        $s3->put($path . '/' . $image_name, $filePathLargeResource, 'public');
        $file = new UserFile();
        $file->user_id = $id;
        $file->file_path = $image_name;
        $file->save();
        return response()->json(compact('file'));
    }

    public function deleteFile($id)
    {
        $file = UserFile::find($id);
        Storage::disk('s3')->delete(str_replace(config('image_s3.base_url'), '', $file->file_path));
        $file->delete();
        return response()->json(['success' => true]);
    }

    public function checkEmail(Request $request)
    {

        $fleet = User::where("email", $request->email)->get()->first();
        if ($fleet) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function checkPhone(Request $request)
    {

        $fleet = User::where("phone", $request->phone)->get()->first();
        if ($fleet) {
            return 'false';
        } else {
            return 'true';
        }

    }

    public function endpoint(Request $request, $id)
    {
        $uid = EndPoint::where('client_id', $id)->first();
        if ($uid == null) {
            $endpoint = EndPoint::create(
                ['endpoint' => $request->endpoint, 'client_id' => $id],
            );
        } else {
            $endpoint = EndPoint::find($uid->id);
            $endpoint->endpoint = $request->endpoint;
            $endpoint->save();

        }


    }

    public function getClients(Request $request, $id)
    {

        $user = auth('api')->user();
        $statuses = UserStatus::all();

        $query = Client::join('users', 'users.id', '=', 'clients.user_id')
            ->where(['clients.admin_id' => $id]);

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
        //     $column = $sorter->column == '' ? 'created_at' : $sorter->column;
        //     $query->orderBy($column, $by);
        // }
        $fleets = $query->paginate($request->get('itemsLimit'));


        return response()->json(compact('fleets', 'statuses'));


    }
}
