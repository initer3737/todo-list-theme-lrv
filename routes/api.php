<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\Top3Controller;
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
    // Route::get('/user/session',[UserInfoController::class, 'UserInfoSession']);
    Route::get('/scope',[LobbyController::class, 'LobbyInfo']);
    Route::post('/login',[AuthController::class, 'Login']);
    Route::post('/register',[AuthController::class, 'Register']);
    Route::post('/reset',[AuthController::class, 'Reset']);
        //protected one
        // Route::get('/user/{username}',[UserInfoController::class, 'UserInfo']);
        Route::group(['middleware'=>'auth:api'],function(){
                //post
            Route::post('/setting',[UserSettingController::class, 'UserSetting']);
            Route::post('/game/update',[GameController::class, 'gameUpdateScore']);
                //get 
            Route::get('/game/score',[GameController::class, 'gameGetScore']);
            Route::get('/lobby',[LobbyController::class, 'LobbyInfo']);
            Route::get('/top3/players/info',[Top3Controller::class, 'Top3PlayerInfo']);
            Route::get('/user/conections/counting',[LobbyController::class, 'UserCountingConnectionInfo']);
            Route::get('/setting/info',[UserSettingController::class, 'UserSettingInfo']);
            Route::get('/user/{username}',[UserInfoController::class, 'UserInfo']);
            Route::get('/session/profile',[UserInfoController::class, 'UserInfoSession']);
            Route::get('/logout',[AuthController::class, 'Logout']);
        });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
