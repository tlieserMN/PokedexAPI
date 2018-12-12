<?php

use Illuminate\Http\Request;

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


//Differs per trainer
Route::post("/capture", "PokedexController@capture");
Route::get("/captured", "PokedexController@captured");

//REST
Route::get("/pokemon/{id?}", "PokedexController@get");
Route::post("/updatepokemon", "PokedexController@update"); // or put
Route::post("/createpokemon", "PokedexController@create");
Route::post("/deletepokemon", "PokedexController@delete"); // delete
