<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-person', 'App\Http\Controllers\PersonController@getPerson');

Route::post('create-person', 'App\Http\Controllers\PersonController@createPerson');
Route::get('get-persons', 'App\Http\Controllers\PersonController@getPersons');
Route::put('update-person', 'App\Http\Controllers\PersonController@updatePerson');
Route::delete('del-person', 'App\Http\Controllers\PersonController@deletePerson');
