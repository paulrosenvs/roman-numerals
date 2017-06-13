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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('convert/{num}', 'RomanNumeralsController@convert' /*function ()    {
    return response()->json(['name' => 'converted']);
}*/);


/*Route::group(['middleware' => 'auth:api'], function () {
    Route::get('convert', function ()    {
        return response()->json(['name' => 'converted2']);
        // Uses Auth Middleware
    });

    Route::get('show-recent', function () {
        // Uses Auth Middleware
    });

    Route::get('show-top10', function () {
        // Uses Auth Middleware
    });
});*/
