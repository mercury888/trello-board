<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColumnsController;
use App\Http\Controllers\CardsController;

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

Route::group(['middleware' => ['ApiTokenMiddleware']], function () {
    Route::get('export', [ColumnsController::class,'export']);
	Route::get('columns', [ColumnsController::class,'columns']);
	Route::post('column/save', [ColumnsController::class,'save']);
	Route::post('deletecolumn/{column_id}', [ColumnsController::class,'delete']);


	Route::get('list-cards/{column_id}', [CardsController::class,'listCards']);
	Route::post('card/save', [CardsController::class,'save']);
	Route::post('card/update', [CardsController::class,'update']);
	Route::post('card/updateall', [CardsController::class,'updateall']);
});
