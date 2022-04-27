<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|production : vapor IYKiYvvqZYHK3qmK582a3yhzFyZ37ItDKAJlEv4N
*/

use App\Enums\AOrderStatus;
use App\Enums\RouteNumberStatus;
use App\Fleet;
use App\Http\Controllers\Driver\FCMController;
use App\MaxShipmentNumber;
use App\Models\Menurole;
use App\Models\Menus;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\UserStatus;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger ;


use Illuminate\Support\Facades\Storage;
use function Symfony\Component\VarDumper\Dumper\esc;

Route::get('/docs', function () {
    $contents = file_get_contents(asset('docs/index.html'));
    $contents = str_replace(env('APP_URL') . '/', asset('/'), $contents);
    $contents = str_replace('href="css', 'href="' . asset('/') . 'docs/css', $contents);
    $contents = str_replace('src="js', 'src="' . asset('/') . 'docs/js', $contents);
    $contents = str_replace('src="images', 'src="' . asset('/') . 'docs/images', $contents);

    return $contents;
});


Route::any('adminer', '\Aranyasen\LaravelAdminer\AdminerController@index');


Route::get('/pay', 'Driver\PaymentController@pay');

Route::get('/policy', function () {
    return view('policy');
});
Route::get('/shipment', function () {
    return view('shipment');
});
Route::get('/chat/{identity}', function ($identity) {
    $id = getenv("ACCOUNT_ID");
    $key = getenv("ACCOUNT_Key");
    $user = [];
    $user['name'] = $identity;
    $user['id'] = $id;
    $user['email'] = $identity . '@pudo.delivery';
    // PHP
    $digest = hash_hmac(
        'sha256',
        $key,
        $user['email']
    );
    $user['digest'] = $digest;
    return view('chat', compact('user'));
});

Route::get('/tpdf', function () {
    $order=Order::with('user','patch','city','branchWithCity')->find(10);
    $pdf = \PDF::loadView('shipment',compact('order'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a6', 'landscape');
    return $pdf->download('shipment');
    return view('shipment',compact('order'));
});

Route::get('/del', function () {
    $order=Order::all()->whereNotNull('route_number_id');
    foreach ($order as $new){
        $item=Order::find($new->id);
        $item->delete();
    }
    $or=\App\RouteNumber::all();
    foreach ($or as $new2){
        $item2=\App\RouteNumber::find($new2->id);
        $item2->delete();
    }
});


Route::get('/{any}', function () {
    return view('coreui.homepage');
})->where('any', '.*');




