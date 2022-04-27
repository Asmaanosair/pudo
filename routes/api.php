<?php

use App\Http\Controllers\Agent\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', 'Driver\FCMController@Send3Notification');

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('reset', 'AuthController@reset');
Route::get('langlist', 'LocaleController@getLangList');

Route::group(['middleware' => ['api', 'auth']], function ($router) {
    /**************New Edition HR Manager **********************/
    Route::resource('/driver-applications', 'HrDriverController');
    Route::post('change-status-app/{driverId}', 'HrDriverController@changeStatus');
    Route::post('fleet_files/{id}', 'HrDriverController@updateFiles');
    Route::post('profile', 'ProfileController@getProfile');
    Route::post('me', 'ProfileController@me');
    Route::post('edit-profile', 'ProfileController@editProfile');
    Route::post('reset-password', 'ProfileController@resetPassword');
    Route::post('bulk-driver', 'HrDriverController@bulkDriver');
    //======================================= notification =====================================
    Route::post('/notification/get', 'NotificationController@get');
    Route::post('/notification/read', 'NotificationController@read');

    // start new version chat for delivery
    Route::post('/chat/get_all_chat', 'ChatController@getAllChat');
    Route::post('/chat/get_chat/{friend_id}', 'ChatController@getChat');
    Route::post('/chat/send_chat', 'ChatController@sendChat');
    // end new version chat for delivery
    //===================== Create Supplier =======================
    Route::resource('/supplier', 'SuppliersController');
    Route::get('/sup_fleets/{id}/data', 'DriverController@forSupplier');
    Route::post('supplier/addFile/{id}', 'SuppliersController@addFiles');
    Route::post('supplier/deleteFile/{id}', 'SuppliersController@deleteFile');
    //===================== End  Create Supplier =======================

    //===================== Create Client =======================
    Route::resource('/client', 'ClientController');
    Route::post('/endpoint/edit/{id}', 'ClientController@endpoint');
    Route::post('client/addFile/{id}', 'ClientController@addFiles');
    Route::post('client/deleteFile/{id}', 'ClientController@deleteFile');
    Route::post('/get-clients/{$id}', 'ClientController@getClients');
    //===================== End  Create Client =======================

    //===================== Create Branches =======================
    Route::resource('/branch', 'BranchController');
    Route::get('/client/{id}/branch', 'BranchController@branch');
    Route::get('/branches', 'BranchController@branches');
    Route::get('/manager', 'BranchController@manager');

    //===================== Create client Branches =======================
    Route::resource('/client-branch', 'Client_branchController');
    Route::get('/client/{id}/manager', 'Client_branchController@manager');


    //===================== Create commisions  =======================
    Route::resource('/commission', 'CommissionController');
    Route::resource('/real-commission', 'RealCommissionController');

    /**************End Edition HR Manager **********************/
    Route::post('/installNoteDevice', 'UsersController@installNoteDevice');

    Route::post('import-excel', 'OrderController@importExcel');
    Route::post('create-order', 'OrderController@createOrder');
    Route::post('/edit-order/{id}', 'OrderController@editOrder');
    Route::post('/update-order/{id}', 'OrderController@updateOrder');
    Route::delete('/remove-order/{id}', 'OrderController@removeOrder');

    Route::resource('countries', 'CountryController');
    Route::post('change-country/{id}', 'CountryController@changeActive');
    Route::get('cities', 'CityController@index');
    Route::get('cities/{id}', 'HrDriverController@city');
    Route::post('create-city', 'CityController@store');
    Route::delete('/delete-city/{id}', 'CityController@destroy');
    Route::post('city/{id}/edit', 'CityController@edit');
    Route::post('update-city/{id}', 'CityController@Update');
    Route::post('change-active/{id}', 'CityController@changeActive');
});

Route::post('/all_orders', 'OrderController@allOrder');

Route::post('status-order/{id}', 'OrderController@statusOrder');

Route::post('driver/get-status-order/{id}', 'OrderController@statusOrderDriver');

Route::group(['middleware' => ['api', 'auth']], function ($router) {


    Route::post('/installNoteDevice', 'UsersController@installNoteDevice');
    Route::get('menu', 'MenuController@index');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::resource('notes', 'NotesController');
    Route::resource('resource/{table}/resource', 'ResourceController');


    Route::resource('fleets', 'DriverController');
    Route::get('client/wallet/{id}', 'WalletController@walletClient');
    Route::get('main-client/{id}', 'WalletController@ordersClient');
    Route::get('main-fleet/{id}', 'WalletController@ordersFleet');
    Route::get('all_fleet_client', 'WalletController@index');
    Route::get('request-money', 'RequestMoneyController@index');
    Route::post('request-money', 'RequestMoneyController@update');

    Route::get('request-money/{id}/show', 'RequestMoneyController@show');
    Route::get('fleet/wallet/{id}', 'WalletController@wallet');
    Route::get('main', 'WalletController@mainWallet');
    Route::post('check-email', 'SuppliersController@checkEmail');
    Route::post('s-check-phone', 'SuppliersController@checkPhone');
    Route::post('check-phone', 'DriverController@checkPhone');
    Route::post('client/wallet/withdraw/{id}', 'WalletController@withdrawClient');
    Route::post('fleet/wallet/withdraw/{id}', 'WalletController@withdraw');
    Route::post('fleet/wallet/deposit/{id}', 'WalletController@deposit');
    Route::post('client/wallet/deposit/{id}', 'WalletController@depositClient');
    Route::get('fleetsInDuty/{branch_id}', 'DriverController@fleetsInDuty');
    Route::get('/currentOrders', 'OrderController@currentOrders');
    Route::get('/orders/create', 'OrderController@create');
    Route::get('/previousOrder', 'OrderController@previousOrder');
    Route::get('/issueOrder', 'OrderController@issueOrders');
    Route::get('/progressOrder', 'OrderController@progressOrder');
    Route::get('order/{id}', 'OrderController@show');

    Route::post('assignToDriver', 'OrderController@assignToDriver');
    Route::post('reassignToDriver', 'OrderController@reassignToDriver');
    Route::post('fleets/addFile/{fleet_id}', 'DriverController@addFiles');
    Route::post('fleets/deleteFile/{id}', 'DriverController@deleteFile');
    Route::get('map-data', 'MapController@index');
    Route::get('all-statuses', 'OrderController@allStatuses');
    Route::post('change-status/{orderId}', 'OrderController@changeStatus');
    Route::post('send-reason/{orderId}', 'OrderController@sendReason');
    Route::POST('financial', 'FinancialController@orders');
    Route::GET('financial', 'FinancialController@orders');
    Route::post('chart', 'FinancialController@chart');
    Route::get('route-numbers', 'RouteNUmberController@index');
    Route::delete('/remove-batch/{id}', 'RouteNUmberController@removeBatch');
    Route::get('route-numbers/{id}/orders', 'RouteNUmberController@orders');
    Route::get('zip-batch/{id}', 'RouteNUmberController@zipFile');
    Route::post('assignRouteToDriver', 'RouteNUmberController@assignToDriver');

    Route::group(['middleware' => 'admin'], function ($router) {
        Route::post('rules', 'RequestMoneyController@rules');
        Route::resource('roles',        'RolesController');
        Route::resource('cat', 'CategoryController');
        Route::get('rules', 'RequestMoneyController@edit');
        Route::get('shipping-labels', 'MaxShipmentNumberController@edit');
        Route::post('shipping-labels', 'MaxShipmentNumberController@update');

        Route::resource('users', 'UsersController');

        Route::prefix('menu/menu')->group(function () {
            Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
        });
        Route::prefix('menu/element')->group(function () {
            Route::get('/',             'MenuElementController@index')->name('menu.index');
        });

    });
});

/**
 * Drivers Mobile App.
 */
Route::group(['prefix' => 'driver', 'namespace' => 'Driver'], function () {

    Route::post('/login', 'DriverController@login');
    Route::post('/push-notification', 'FCMController@sendNotification');

    // start new version chat for delivery
    Route::post('/chat/get_all_chat', 'ChatController@getAllChat');
    Route::post('/chat/get_chat/{friend_id}', 'ChatController@getChat');
    Route::post('/chat/send_chat', 'ChatController@sendChat');
    // end new version chat for delivery

    /**************New Edition Driver **********************/
    Route::get('testTo', 'FCMController@TestNotification');
    Route::post('/register', 'DriverController@register');
    Route::post('/reset', 'DriverController@reset');
    Route::get('companies', 'DriverController@companies');
    Route::get('countries', 'DriverController@countries');
    Route::post('/verification', 'DriverController@verification');

    Route::post('/register_upload', 'DriverController@registerUploads');
    /**************New Edition Driver **********************/
    Route::group(['middleware' => 'jwtAuthFleet'], function () {

        Route::post('/request-money', 'DriverController@requestMoney');
        Route::get('/request-money', 'DriverController@requestsMoney');
        /************** New Edition Driver **********************/
        Route::get('get-orders', 'DriverController@getOrdersHistory');
        Route::post('device-token', 'FCMController@saveToken');

        Route::get('/new-orders', 'DriverController@newOrders');
        /************** New Edition Driver **********************/
        Route::get('/profile', 'DriverController@profile');
        Route::post('/profile', 'DriverController@editProfile');
        Route::post('/upload-files', 'DriverController@uploadFiles');
        Route::post('/invoice', 'DriverController@uploadInvoice');

        /************** End Edition Driver **********************/
        Route::get('/orders', 'DriverController@orders');
        Route::get('/order/{id}', 'DriverController@order');
        Route::post('/acceptOrder/{id}', 'DriverController@acceptOrder');
        Route::post('/pay-status', 'DriverController@paymentStatus');
        Route::post('/rejectOrder/{id}', 'DriverController@rejectOrder');
        Route::post('/changeStatus/{id}', 'DriverController@changeStatus');
        Route::post('/onlineStatus', 'DriverController@onlineStatus');
        Route::get('/ordersHistory', 'DriverController@ordersHistory');
        Route::post('/summary', 'DriverController@getSummary');
        Route::get('/refreshToken', 'DriverController@refreshToken');
        Route::post('/installNoteDevice', 'DriverController@installNoteDevice');
        Route::post('/locationNow', 'DriverController@locationNow');
        Route::post('/wallet', 'DriverController@wallet');
        Route::get('/statistics', 'StatisticsController@indexNew');
        Route::post('/walletTransfer', 'DriverController@walletTransfer');
        Route::post('/walletPay', 'DriverController@walletPay');
        Route::post('/pay', 'PaymentController@pay');
        /************** New Version 2 **********************/
        Route::get('/new-orders/v2', 'DriverControllerV2@newOrders');
        Route::get('/new-batch', 'DriverControllerV2@newBatches');
        Route::get('/batch-orders', 'DriverControllerV2@BatchOrders');
        Route::get('/accept-batch/{id}', 'DriverControllerV2@acceptBatches');
        Route::get('/reject-batch/{id}', 'DriverControllerV2@rejectBatches');
        Route::post('/scan-order', 'DriverControllerV2@scanOrder');
        Route::post('/scan-batch', 'DriverControllerV2@scanBatch');
        Route::get('/get-orders/v2', 'DriverControllerV2@getOrdersHistory');
        Route::get('/get-batches', 'DriverControllerV2@getBatchHistory');
        Route::post('/acceptOrder/v2/{id}', 'DriverControllerV2@acceptOrder');
        /************** End New Version 2 **********************/

    });
});

/**
 * Integration with other systems.
 */
Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'middleware' => ['auth.apikey', 'agent.api.id']], function () {
    Route::post('/order/create', 'OrderController@create');
    Route::post('/order/show', 'OrderController@show');
    Route::post('/order/update', 'OrderController@update');
    Route::post('/order/delete', 'OrderController@delete');
    Route::post('/order/assignToDriver', 'OrderController@assignToDriver');
    Route::post('/order/reassignToDriver', 'OrderController@reassignToDriver');
});

