<?php

use App\Http\Controllers\api\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('User_login', [AuthController::class,'User_login']);

Route::post('Admin_login', [AuthController::class,'Admin_login']);
Route::post('Confirm_Two_Factor_Code', [AuthController::class,'Confirm_Two_Factor_Code']);


Route::group(['middleware'=>['auth:contacts']],function(){

    Route::get('InsertLog', [AuthController::class,'InsertLog']);

});
