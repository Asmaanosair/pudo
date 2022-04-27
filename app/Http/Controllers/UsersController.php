<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Device;
use App\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //    public function __construct()
    //    {
    //        $this->middleware('auth:api');
    //    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $statuses = UserStatus::all();
        return response()->json(['status' => $statuses], 200);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [  //validate inputs
            "phone" => 'required',
            "name" => 'required|min:6|max:40',
            "email" => 'required|email|unique:users',
            "status" => 'required',
            "role" => "required",
            "password" => 'required|min:8'
        ]);

        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }

        $fleet = new User();

        $user = User::where('menuroles', 'user,admin')->get()->first();
        $fleet->commission_id = $user->commission_id;
        $fleet->commission_id = $user->commission_id;
        $fleet->phone = $request->get('phone');
        $fleet->status = $request->get('status');
        $fleet->email = $request->get('email');
        $fleet->name = $request->get('name');
        $fleet->uuid = $request->get('uid');
        $fleet->menuroles = $request->get('role');
        $fleet->password = bcrypt($request->get('password'));
        $fleet->save();
        $fleet->assignRole($request->get('role'));
        return response()->json(['status' => 'success']);
    }
    public function index()
    {
        $you = auth()->user()->id;
        $users = DB::table('users')
            ->select('users.id', 'users.name', 'users.email', 'users.menuroles as roles', 'users.status', 'users.created_at as registered')
            ->whereNull('deleted_at')->whereNotIn('menuroles', ['user', 'client', 'client-branch'])
            ->get();
        return response()->json(compact('users', 'you'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')
            ->select('users.id', 'users.name', 'users.email', 'users.menuroles as roles', 'users.status', 'users.email_verified_at as registered')
            ->where('users.id', '=', $id)
            ->first();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')
            ->select('users.id', 'users.name', 'users.email', 'users.menuroles as roles', 'users.status', 'users.phone')
            ->where('users.id', '=', $id)
            ->first();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [  //validate inputs
            "phone" => 'required',
            "name" => 'required|min:6|max:40',
            "email" => 'required|email|unique:users'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->status      = $request->input('status');
        $user->menuroles      = $request->input('role');
        if ($request->has('password')){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        $role=DB::table('model_has_roles')->where('model_id',$id)->get();
        if(count($role)!=0){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->get('role'));
        }else{
            $user->assignRole($request->get('role'));
        }
        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return response()->json(['status' => 'success']);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function installNoteDevice(Request $request)
    {
        $device = Device::updateOrCreate(
            ['player_id' => $request->get('player_id')],
            [
                'os' => $request->get('os'),
                'user_type' => 'User',
                'player_id' => $request->get('player_id'),
                'user_id' => auth()->user()->id

            ]
        );

        return response()->json(['message' => null, 'data' => $device]);
    }
}
