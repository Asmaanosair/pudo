<?php

namespace App\Http\Controllers;

use App\ApplicationStatus;
use App\City;
use App\Country;
use App\Enums\AOrderStatus;
use App\Enums\ContractType;
use App\Enums\DriverApply;
use App\Fleet;
use DB;
use App\FleetFile;
use App\Models\Users;
use App\Order;
use App\Rules\AgeValidationRule;
use App\User as AppUser;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Importer;

class HrDriverController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('api')->user();
        $app = DB::table('application_statuses');
        $query = Fleet::with('applicationStatus', 'user');
        if ($user->menuroles == 'user') {
            $query->where('user_id', $user->id);
            $app->whereNotIn('id', [3, 5]);
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
            $column = $sorter->column == '' ? 'last_login' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $statuses = $app->get();
        $fleets = $query->paginate($request->get('itemsLimit'));
        $onlineCount = $query->where("status", 'online')->count();
        foreach ($fleets as $fleet) {
            $balance = $fleet->balanceFloat;
            $fleet['fleet_balance'] = $balance;
        }


        return response()->json(compact('fleets', 'onlineCount', 'statuses', 'user'));
    }

    public function changeStatus($driverId, Request $request)
    {
        $query = Fleet::where('id', $driverId);
        $query->update(["application_status_id" => $request->get('status_id')]);
        $order = $query->first();
        return response()->json(compact('order'));
    }


    public function show($id)
    {
        $fleet = Fleet::with('files', 'applicationStatus', 'city', 'user')->whereId($id)->first();
        $mytime = Carbon::now()->format('Y-m-d');
        $dateOfBirth = Carbon::createFromFormat('Y-m-d', $fleet->date_of_birth);
        $years = Carbon::parse($dateOfBirth)->age;
        $fleet->age = $years;
        $country = Country::find((int)$fleet->country);


        return response()->json(compact('fleet', 'country'));
    }

    public function create()
    {

        $statuses = ApplicationStatus::all();
        $countries = Country::all()->where('active', 1);
        $user = auth('api')->user();
        $suppliers = \App\User::where('menuroles', 'user')->get();

        return response()->json(['status' => $statuses, 'user' => $user, 'suppliers' => $suppliers, 'countries' => $countries], 200);
    }

    public function city($id)
    {

        $countries = Country::find($id);
        $cities = DB::table('cities')
            ->selectRaw(" id,name,ST_AsText(cities.geom)")
            ->where('country_id', $countries->id)->where('active', 1)->get();
        $countrygeom = DB::table('countries')
            ->selectRaw(" ST_AsText(countries.geom)")
            ->where('id', $id)->first();

        return response()->json(['cities' => $cities, 'countrygeom' => $countrygeom], 200);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $supplier = [];
        if ($user->menuroles != 'user') {
            $supplier = ['required'];
        }
        $validatedData = $request->validate([
            "mobile" => 'required|unique:fleets|numeric|min:10',
            "name" => 'required',
            "identity" => 'required|unique:fleets|min:10',
            "age" => 'required',
            // "age" => ['required','numeric',new AgeValidationRule()],
            "contract_type" => "required",
            //   "country"=>"required",
            "gender" => "required",
            "vehicle_type" => "required",
            "bank_name" => "required",
            "supplier_id" => $supplier,
            "bank_iban" => "required",
            //  "city"=>"required",

        ]);
        $supplier_id = $request->supplier_id;
        $maxCode = Fleet::max('code');
        $fleet = new Fleet();
        if ($user->menuroles = !'user') {
            $supplier_id = $user->id;
        }
        $fleet->user_id = $supplier_id;

        $fleet->supplier_uuid = $user->uuid;

        $fleet->code = intval($maxCode) + 1;
        $fleet->mobile = $request->get('mobile');
        $fleet->bank_iban = $request->get('bank_iban');
        $fleet->application_status_id = $request->get('application_status_id');
        $fleet->name = $request->get('name');
        $fleet->identity = $request->get('identity');
        $fleet->nationality = $request->get('nationality');
        $fleet->date_of_birth = date("Y-m-d", strtotime($request->age));
        $fleet->uuid = $request->get('uuid');
        $fleet->bank_name = $request->get('bank_name');
        $fleet->gender = $request->get('gender');
        //    $fleet->country = $request->get('country');
        $fleet->country = 'ttrtrt';
        $fleet->vehicle_type = $request->get('vehicle_type');
        // $fleet->city_id = $request->get('city');
        $fleet->city_id = 1;
        $fleet->contract_type = $request->get('contract_type');
        $fleet->status = 'offline';
        $fleet->image = null;
        $fleet->password = bcrypt($request->get('password'));
        $fleet->save();

        return response()->json(['status' => 'success']);
    }


    public function edit($id)
    {
        $user = auth('api')->user();
        $fleet = Fleet::with('files', 'applicationStatus')->whereId($id)->first();
        $suppliers = \App\User::where('menuroles', 'user')->get();
        $countries = Country::all()->where('active', 1);
        $cities = City::all()->where('active', 1);
        if ($user->menuroles == 'user') {
            $status = ApplicationStatus::whereIn('id', [
                DriverApply::APPROVED_BY_SUPPLIER,
                DriverApply::NEW_APP,
                DriverApply::REJECTED_BY_SUPPLIER,
            ])->get();
            return response()->json(compact('fleet', 'status', 'user', 'countries', 'cities'));
        }
        $status = ApplicationStatus::all();
        $user = auth('api')->user();
        return response()->json(compact('fleet', 'status', 'suppliers', 'user', 'countries', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        $supplier = [];
        if ($user->menuroles != 'user') {
            $supplier = ['required'];
        }

        $validatedData = $request->validate([
            "mobile" => 'required|numeric|min:10',
            "name" => 'required',
            "identity" => 'required|min:10',
            "nationality" => 'required',
            // "age" => ['required','numeric',new AgeValidationRule()],

            "contract_type" => "required",
            "country" => "required",
            "city" => "required",
            "gender" => "required",
            "vehicle_type" => "required",
            "bank_name" => "required",
            "supplier_id" => $supplier,
            "bank_iban" => "required",

        ]);

        $inputs = $request->all();
        $supplier_id = $request->supplier_id;


        $fleet = Fleet::find($id);

        if ($user->menuroles = !'user') {
            $supplier_id = $user->id;
        }
        $fleet->user_id = $supplier_id;
        $fleet->mobile = $request->get('mobile');
        $fleet->bank_iban = $request->get('bank_iban');
        $fleet->application_status_id = $request->get('application_status_id');
        $fleet->name = $request->get('name');
        $fleet->identity = $request->get('identity');
        $fleet->nationality = $request->get('nationality');
        if ($request->get('block') == 1) {
            $fleet->status = 'suspended';
        }
        $fleet->block = $request->get('block');
        $fleet->user_id = $request->get('supplier_id');
        $fleet->city_id = $request->get('city');
        // $suplier = AppUser::find($request->get('supplier_id'));
        // $fleet->supplier_uuid = $suplier->uuid;
        $fleet->country = $request->get('country');
        $fleet->date_of_birth = date("Y-m-d", strtotime($request->age));
        $fleet->uuid = $request->get('uuid');
        $fleet->bank_name = $request->get('bank_name');
        $fleet->vehicle_type = $request->get('vehicle_type');
        // $fleet->nationalityId = $request->get('nationalityId');
        $fleet->contract_type = $request->get('contract_type');
        if (strlen($request->password) >= 8) {
            $password = Hash::make($request->password);
            $fleet->password = $password;
        }
        $fleet->save();
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $fleet = Fleet::find($id);
        if ($fleet)
            $fleet->delete();
        return response()->json(['status' => 'success']);
    }

    public function bulkDriver(Request $request)
    {

        $file = $request->file('file');
        $excel = Importer::make('Excel');
        $excel->Load($file);
        $collection = $excel->getCollection();
        $user = auth()->user();

        for ($row = 1; $row < sizeof($collection); $row++) {
            try {
                $main_inputs = [];
                $inputs_text = $collection[0];
                $inputs_value = $collection[$row];
                for ($j = 0; $j < sizeof($collection[0]); $j++) {
                    $main_inputs[$inputs_text[$j]] = $inputs_value[$j];
                }

                $supplier = [];

                if ($user->menuroles != 'user') {
                    $supplier = ['required', 'exists:users'];

                    $main_inputs['user_id'] = $main_inputs['supplier_id'];
                    if (isset($main_inputs['supplier_id'])) {
                        $main_inputs['id'] = $main_inputs['supplier_id'];
                    }
                } else {
                    $main_inputs['user_id'] = $user->id;
                }

                $validation_inputs = Validator::make($main_inputs, [

                    "mobile" => 'required|unique:fleets|numeric|min:10',
                    //'password' => 'required|min:6',
                    "name" => 'required',
                    "identity" => 'required|unique:fleets|min:10',
                    // "age" => 'required',
                    "contract_type" => "required",
                    "gender" => "required",
                    "vehicle_type" => "required",
                    "bank_name" => "required",
                    "id" => $supplier,
                    "bank_iban" => "required|min:24",
                    "date_of_birth" => "required"


                ]);


                if ($validation_inputs->fails()) {
                    $errors = $validation_inputs->errors();
                    return view('errors', ['my_errors' => $errors]);
                }


                $maxCode = Fleet::max('code');
                $main_inputs['verification_code'] = 123456;
                $main_inputs['application_status_id'] = 1;
                $main_inputs['code'] = intval($maxCode) + 1;
                $main_inputs['status'] = 'offline';


                $chars = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                $serial = '';
                $max = count($chars) - 1;
                for ($i = 0; $i < 40; $i++) {
                    $serial .= (!($i % 5) && $i ? '-' : '') . $chars[rand(0, $max)];
                }

                $main_inputs['uuid'] = $serial;
                $mobile = $main_inputs['mobile'];
                $main_inputs['supplier_uuid'] = $user->uuid;
                $main_inputs['image'] = null;
                $pass = random_int(100000, 999999);
                $main_inputs['password'] = bcrypt($pass);
                $NId = $main_inputs['identity'];
                $fleet = Fleet::create($main_inputs);
                $api_key = Config::get("sms.api_key");
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, TRUE);

                curl_setopt($ch, CURLOPT_POST, TRUE);

                $fields = <<<EOT
                            {
                              "userName": "pudo",
                              "numbers": $mobile,
                              "userSender": "PUDO",
                              "apiKey": "81996d9f14eec357f3fe63280ac6e47f",
                              "msg": "Your National ID is :  $NId  && Your Password is : $pass" ,
                              "msgEncoding":"UTF8"
                            }
                            EOT;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json"
                ));

                $response = curl_exec($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);


            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return redirect('/#/driver-applications/');
    }
}
