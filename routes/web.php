<?php

use App\Events\Test;
use App\Events\NewEvent;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
require app_path() . '/Loader/Load.php';

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

//admin login
Route::get('/admin/login', 'App\Http\Controllers\Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'App\Http\Controllers\Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin/logout', 'App\Http\Controllers\Auth\AdminLoginController@logout')->name('admin.logout');

//Admin Routes with authentication
Route::group(['middleware'=>['auth:admin']], function() 
{
    Route::get('/admin/index', function () {
        return view('admin.index');
    })->name('admin.index');
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@index')->name('admin.dashboard');
});
//Autoload
Route::get('/loader', function () {
    echo (new Loader\Load)->index();
});