<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(SubscriptionsController::class)->group(function () {
  Route::post('subscribe/{topic}', 'subscribe');
});

Route::controller(PublicationsController::class)->group(function(){
  Route::post('publish/{topic}', 'publish');
  Route::post('test1', 'getMesaage');
  Route::post('test2', 'getMesaage');
});