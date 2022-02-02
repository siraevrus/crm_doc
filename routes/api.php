<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDocumentController;

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

Route::prefix('/clients')->group(function(){
    Route::post('/', [ClientController::class, 'create']);
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{client}', [ClientController::class, 'get']);
    Route::put('/{client}', [ClientController::class, 'update']);
    Route::delete('/{client}', [ClientController::class, 'delete']);
});

Route::prefix('/documents')->group(function(){
    Route::post('/', [ClientDocumentController::class, 'upload']);
    Route::put('/{document}', [ClientDocumentController::class, 'update']);
    Route::delete('/{document}', [ClientDocumentController::class, 'delete']);
});
