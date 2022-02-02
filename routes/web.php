<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function() {
    Route::get('/', function () {
        return view('clients');
    });

    Route::get('/add', function (){
        return view('clients_add');
    });

    Route::get('/{client}', function (\App\Models\Client $client) {
        return view('clients_edit', ['clientID' => $client->id]);
    });
});

Auth::routes();
