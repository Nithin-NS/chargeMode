<?php

use App\Events\Test;
use App\Events\NewEvent;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\StationMessageController;
use App\Http\Controllers\AdminController;
// use app\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Client Routes
Route::get('/getChargepoints', [ClientController::class, 'getChargepoints']);
Route::get('/getConnectors', [ClientController::class, 'getConnectors']);
Route::get('/client', function () {
    return view('client.client');
});
Route::get('/newclient', function () {
    return view('client.newclient');
});
Route::post('/getBootNotification', [ClientController::class, 'bootNotification']);
Route::post('/authenticate', [ClientController::class, 'authenticate']);
Route::post('/startCharging', [ClientController::class, 'startCharging']);
Route::post('/meterValues', [ClientController::class, 'meterValues']);
Route::post('/heartBeat', [ClientController::class, 'heartBeat']);
Route::post('/stopCharging', [ClientController::class, 'stopCharging']);

//From Admin to Client
Route::post('/sendBootNotificationResponce', [AdminNotificationController::class, 'BootNotificationResponce']);
Route::post('/sendAuthenticateResponse', [AdminNotificationController::class, 'AuthenticateResponse']);
Route::post('/sendTransactionResponse', [AdminNotificationController::class, 'TransactionResponse']);
Route::post('/sendMeterValues', [AdminNotificationController::class, 'MeterValues']);
Route::post('/sendHeartBeatResponce', [AdminNotificationController::class, 'HeartBeatResponce']);
Route::post('/sendStopTransaction', [AdminNotificationController::class, 'StopTransaction']);


//User Routes with authentication
Route::group(['middleware'=>['auth']], function() 
{
    // Route::get('/client', function () {
    //     return view('client.client');
    // });
});
//user routes
Route::get('/users/logout', 'App\Http\Controllers\Auth\LoginController@userLogout')->name('user.logout');



Route::get('/admin/index', function () {
    return view('admin.index');
})->name('admin.index');

//admin login
Route::get('/admin/login', 'App\Http\Controllers\Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'App\Http\Controllers\Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin/logout', 'App\Http\Controllers\Auth\AdminLoginController@logout')->name('admin.logout');

//Admin Routes with authentication
Route::group(['middleware'=>['auth:admin']], function()
{
    //Dashboard Routes
    Route::get('/admin/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    
    //Connector Routes
    Route::get('/admin/connector', 'App\Http\Controllers\ConnectorController@index')->name('connector');
    Route::get('/admin/createconnector', 'App\Http\Controllers\ConnectorController@create')->name('createconnector');
    Route::post('/admin/saveconnector', 'App\Http\Controllers\ConnectorController@store')->name('saveconnector');
    Route::get('/admin/connector/edit/{id}', 'App\Http\Controllers\ConnectorController@show')->name('showconnector');
	Route::post('/connector/update/{id}','App\Http\Controllers\ConnectorController@update')->name('updateconnector');
	Route::get('/connector/delete/{id}','App\Http\Controllers\ConnectorController@destroy')->name('deleteconnector');
	Route::get('/searchconnector','App\Http\Controllers\ConnectorController@search_connector')->name('searchconnector');

    //Charge Point Routes
    Route::get('/admin/chargepoint', 'App\Http\Controllers\ChargePointController@index')->name('chargepoints');
    Route::get('/admin/addchargepoint', 'App\Http\Controllers\ChargePointController@create')->name('addchargepoint');
    Route::post('/admin/savechargepoint', 'App\Http\Controllers\ChargePointController@store')->name('savechargepoint');
	Route::get('/chargepoint/details/{id}','App\Http\Controllers\ChargePointController@details')->name('chargepointdetails');
	Route::get('/chargepoint/edit/{id}','App\Http\Controllers\ChargePointController@show')->name('chargepointshow');
	Route::post('/chargepoint/update/{id}','App\Http\Controllers\ChargePointController@update')->name('chargepointupdate');
	Route::get('/chargepoint/delete/{id}','App\Http\Controllers\ChargePointController@destroy')->name('chargepointdelete');
	Route::get('/searchchargepoint','App\Http\Controllers\ChargePointController@searchchargepoint')->name('chargepointsearch');

    //transaction Routes
    Route::get('/admin/transaction', 'App\Http\Controllers\TransactionController@index')->name('transactions');
	Route::get('/transactions/edit/{id}','App\Http\Controllers\TransactionController@show')->name('edittransaction');
	Route::post('/transactions/update/{id}','App\Http\Controllers\TransactionController@update')->name('updatetransaction');
	Route::get('/transactions/delete/{id}','App\Http\Controllers\TransactionController@destroy')->name('deletetransaction');

    //customer Routes
    Route::get('/admin/customer', 'App\Http\Controllers\CustomerController@index')->name('customers');

    Route::get('/getUserDetails', 'App\Http\Controllers\CustomerController@getUserDetails')->name('getUserDetails');
    Route::get('/findChargePoints', 'App\Http\Controllers\CustomerController@findChargePoints')->name('findChargePoints');

    Route::get('/admin/addcustomer', 'App\Http\Controllers\CustomerController@create')->name('addcustomer');
    Route::post('/admin/savecustomer', 'App\Http\Controllers\CustomerController@store')->name('savecustomer');
	Route::get('/customer/edit/{id}','App\Http\Controllers\CustomerController@show')->name('editcustomer');
	Route::post('/customer/update/{id}','App\Http\Controllers\CustomerController@update')->name('updatecustomer');
	Route::get('/customer/delete/{id}','App\Http\Controllers\CustomerController@destroy')->name('deletecustomer');
	Route::get('/searchuser','App\Http\Controllers\CustomerController@searchcustomer')->name('searchcustomer');

    //Message Routes
    Route::get('/admin/messages', 'App\Http\Controllers\StationMessageController@index')->name('messages');  
    Route::get('/getDeviceMessages', 'App\Http\Controllers\StationMessageController@getDeviceMessages')->name('getDeviceMessages');  
    Route::get('/clearDeviceMessages', 'App\Http\Controllers\StationMessageController@clearDeviceMessages')->name('clearDeviceMessages');  

    //Remote Operations Routes
	Route::get('/findConnectors','App\Http\Controllers\RemoteOperationController@findConnectors')->name('findConnectors');
	Route::post('/remoteStart/{id}','App\Http\Controllers\RemoteOperationController@remotestart')->name('remotestart');
	Route::post('/remoteStop/{id}','App\Http\Controllers\RemoteOperationController@remotestop')->name('remotestop');

});