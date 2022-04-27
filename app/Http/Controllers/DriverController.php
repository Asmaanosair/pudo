<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Enums\AOrderStatus;
use App\Enums\DriverApply;
use App\Fleet;
use App\FleetFile;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DriverController extends Controller
{
    public function forSupplier($id,Request $request){

        $query = Fleet::query()->where('user_id',$id);
        if ($request->has('columnFilter')){
            $columnFilters = json_decode($request->columnFilter,true);
            foreach ($columnFilters as $key=>$value){
                if ($value != "")
                    $query->where($key,'LIKE','%'.$value.'%');
                if ($key = "status")
                    $query->where($key,$value);
            }
        }
        if ($request->has('sorter')){
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc==true?'ASC':'DESC';
            $column = $sorter->column == ''?'last_login':$sorter->column;
            $query->orderBy($column,$by);
        }
        $fleets = $query->paginate($request->get('itemsLimit'));
        $onlineCount  = $query->where("status",'online')->count();

        foreach ($fleets as $fleet){
            $balance = $fleet->balanceFloat;
            $fleet['fleet_balance'] = $balance;
        }

        return response()->json(compact('fleets','onlineCount'));
    }
    public function index(Request $request){
        $user = auth('api')->user();
        $query = Fleet::query();
        if ($user->menuroles=='user'||$user->menuroles=='dispatcher'||$user->menuroles=='support') {
            $query->where('user_id', $user->id);
        }
        if ($request->has('columnFilter')){
            $columnFilters = json_decode($request->columnFilter,true);
            foreach ($columnFilters as $key=>$value){
                if ($value != "")
                    $query->where($key,'LIKE','%'.$value.'%');

            }
        }
        if ($request->status!=null) {
            $query->where('status', $request->status);
        }
        if ($request->has('sorter')){
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc==true?'ASC':'DESC';
            $column = $sorter->column == ''?'last_login':$sorter->column;
            $query->orderBy($column,$by);
        }
        $fleets = $query->whereIn('application_status_id',[DriverApply::APPROVED_BY_PUDO,DriverApply::APPROVED_BY_SUPPLIER])->paginate($request->get('itemsLimit'));
        $onlineCount  = $query->where("status",'online')->count();

        foreach ($fleets as $fleet){
            $balance = $fleet->balanceFloat;
            $fleet['fleet_balance'] = $balance;
        }

        return response()->json(compact('fleets','onlineCount'));
    }


    public function show($id){

        $fleet = Fleet::whereId($id)->with('files')->first();

        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        //delivered
        $delivered_day  = $fleet->orders()->where('order_status_id',AOrderStatus::DELIVERED)
            ->where('created_at',Carbon::today())->count();

        $delivered_week  = $fleet->orders()->where('order_status_id',AOrderStatus::DELIVERED)
            ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $delivered_month  = $fleet->orders()->where('order_status_id',AOrderStatus::DELIVERED)
            ->whereYear('created_at',date('Y'))
            ->whereMonth('created_at',date('m'))
            ->count();

        //canceled
        $canceled_day  = $fleet->orders()->where('order_status_id',AOrderStatus::CANCELED)
            ->where('created_at',Carbon::today())->count();

        $canceled_week  = $fleet->orders()->where('order_status_id',AOrderStatus::CANCELED)
            ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $canceled_month  = $fleet->orders()->where('order_status_id',AOrderStatus::CANCELED)
            ->whereYear('created_at',date('Y'))
            ->whereMonth('created_at',date('m'))
            ->count();

        //current
        $current_orders  = $fleet->orders()->whereNotIn('order_status_id',
            [AOrderStatus::DELIVERED,AOrderStatus::CANCELED, AOrderStatus::RETURNED, AOrderStatus::FAILED_TO_RETURN])
            ->count();


        $statistics  =[];
        $statistics["delivered_orders_day"]["value"] = $delivered_day;
        $statistics["delivered_orders_day"]["key"] = 'delivered orders today';
        $statistics["delivered_orders_day"]["color"] = 'success';

        $statistics["delivered_orders-week"]["value"] = $delivered_week ;
        $statistics["delivered_orders-week"]["key"] = 'delivered orders this week';
        $statistics["delivered_orders-week"]["color"] = 'success';

        $statistics["delivered_orders_month"]["value"] = $delivered_month;
        $statistics["delivered_orders_month"]["key"] = "delivered_orders this month";
        $statistics["delivered_orders_month"]["color"] = "success";

        $statistics["on_work_orders"]["value"] = $current_orders;
        $statistics["on_work_orders"]["key"] = 'working on orders';
        $statistics["on_work_orders"]["color"] = 'primary';

        $statistics["canceled_orders_day"]["value"] = $canceled_day;
        $statistics["canceled_orders_day"]["key"] = "canceled orders today";
        $statistics["canceled_orders_day"]["color"] = "danger";

        $statistics["canceled_orders-week"]["value"] = $canceled_week ;
        $statistics["canceled_orders-week"]["key"] = "canceled orders this week" ;
        $statistics["canceled_orders-week"]["color"] = "danger" ;

        $statistics["canceled_orders_month"]["value"] = $canceled_month;
        $statistics["canceled_orders_month"]["key"] = "canceled orders this month";
        $statistics["canceled_orders_month"]["color"] = "danger";

        return response()->json(compact('fleet','statistics'));
    }

    public function create(){
        return response()->json([],200);
    }

    public function store(Request $request){
        $user = auth('api')->user();
        $validatedData = $request->validate([
            "mobile"=>'required',
            "name"=>'required',
            "identity"=>'required|min:10|max:15',

        ]);
        $maxCode = Fleet::max('code');
        $fleet= new Fleet();
        $fleet->user_id=$user->id;
        $fleet->code = intval($maxCode)+1;
        $fleet->mobile = $request->get('mobile');
        $fleet->name = $request->get('name');
        $fleet->identity = $request->get('identity');
        $fleet->status = 'offline';
        $fleet->image = null;
        $fleet->password = bcrypt($request->get('password'));
        $fleet->save();
        return response()->json( ['status' => 'success'] );
    }

    public function edit($id){
        $fleet = Fleet::with('files')->whereId($id)->first();

        return response()->json(compact('fleet'));
    }

    public function update(Request $request,$id){
        $inputs = $request->all();
        $fleet = Fleet::find($id);
        $inputs["password"] = bcrypt($inputs["password"]);
        $fleet->update($inputs);
        return response()->json( ['status' => 'success'] );
    }
    public function destroy($id){
        $fleet = Fleet::find($id);
        if ($fleet)
            $fleet->delete();
        return response()->json( ['status' => 'success'] );

    }
    public function fleetsInDuty(Request $request,$branch_id){

        $user = auth('api')->user();
        $branch = Branch::find($branch_id);
        $query = Fleet::withCount('orders')->whereNotNull('device_token');
        if (!$user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }
        if ($request->has('columnFilter')){
            $columnFilters = json_decode($request->columnFilter,true);
            foreach ($columnFilters as $key=>$value){
                if ($value != "")
                    $query->where($key,'LIKE','%'.$value.'%');
            }
        }
        if ($request->has('sorter')){
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc==true?'ASC':'DESC';
            $column = $sorter->column == ''?'last_login':$sorter->column;
            $query->orderBy($column,$by);
        }
         $query->whereRaw("ST_DWithin(
                         ST_MakePoint(lng , lat)::geography,
                         ST_MakePoint($branch->pickup_lng, $branch->pickup_lat)::geography,
                         12000)");

        $query->whereIn('status',['online','free']);
        $fleets = $query->orderBy('orders_count')->paginate(10);
        return response()->json(compact('fleets'));
    }


    public function addFiles($fleet_id, Request $request){

        $image = $request->file('file');
        $ext = $request->file('file')->getClientOriginalExtension();
        $path = '/fleets';
        $rand = rand(1, 999999);
        $date = Date('ymdhis');
        $image_name = $rand . $date . '.' . $ext;
        $filePathLarge = Image::make($image->getRealPath())->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        });
        $filePathLargeResource = $filePathLarge->stream()->detach();
        $s3 = Storage::disk('s3');
//              $s3->put($path . '/original.' . $ext, file_get_contents($filePathOriginal), 'public');
        $s3->put($path . '/'.$image_name, $filePathLargeResource, 'public');
        $file  = new FleetFile();
        $file->fleet_id = $fleet_id;
        $file->file_path = $image_name;
        $file->save();
        if($file->save()){
            $fleet=Fleet::find($fleet_id);
            $fleet->file_uploaded=true;
            $fleet->save();
        }

        return response()->json(compact('file'));
    }

    public function deleteFile($id){
        $file = FleetFile::find($id);
          Storage::disk('s3')->delete(str_replace(config('image_s3.base_url'), '', $file->file_path));
        $file->delete();

        return response()->json(['success'=>true]);
    }




    public function checkPhone(Request $request){

        $fleet = Fleet::where("mobile",$request->mobile)->get()->first();
        if($fleet){
            return 'false';
        }else{
            return 'true';
        }

    }
}
