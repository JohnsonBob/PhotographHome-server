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


Route::any('login', 'API\PassportController@login')->name('login');
Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('get-details', 'API\PassportController@getDetails');
    Route::post('info', 'API\PassportController@info');
    Route::post('/uploadSource', 'PhotoGraphController@uploadSourcePhoto');
    Route::post('/createProject', 'ProjectController@createProject');
    Route::post('/deleteProject', 'ProjectController@deleteProject');

});