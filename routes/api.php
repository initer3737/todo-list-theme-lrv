<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::post('/login',[AuthController::class, 'Login']);
    Route::post('/register',[AuthController::class, 'Register']);
        //protected one
        Route::group(['middleware'=>'auth:api'],function(){
             //get 
            Route::get('/lists',[AuthController::class, 'Lists']);
            Route::get('/logout',[AuthController::class, 'Logout']);
        });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
