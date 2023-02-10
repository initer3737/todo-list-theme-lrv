<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\UserSettingController;
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

//see tutor https://youtu.be/nNvLZ0pWwu4

Route::prefix('v1')->group(function(){
    Route::get('/scope',[LobbyController::class, 'LobbyInfo']);
    Route::post('/login',[AuthController::class, 'Login']);
    Route::post('/register',[AuthController::class, 'Register']);
    Route::post('/reset',[AuthController::class, 'Reset']);
        //protected one
        // Route::get('/user/{username}',[UserInfoController::class, 'UserInfo']);
        Route::group(['middleware'=>'auth:api'],function(){
            //post
            Route::post('/setting',[UserSettingController::class, 'UserSetting']);
             //get 
            Route::get('/lobby',[LobbyController::class, 'LobbyInfo']);
            Route::get('/user/conections/counting',[LobbyController::class, 'UserCountingConnectionInfo']);
            Route::get('/setting/info',[UserSettingController::class, 'UserSettingInfo']);
            Route::get('/user/{username}',[UserInfoController::class, 'UserInfo']);
            Route::get('/logout',[AuthController::class, 'Logout']);
        });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
