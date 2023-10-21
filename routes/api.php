<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function() {
    //logs
    Route::get('logs', 'LogApiController@getLogs');
    Route::get('logs/{id}', 'LogApiController@fetchGetLogs');
    Route::get('logs-roles', 'LogApiController@fetchLogsRole');
    //Route::get('logs-action', 'LogApiController@fetchLogsByAction');

    //books
    // Route::get('books', 'BookApiController@getBooks');
    //Route::get('books/{id}', 'BookApiController@fetchGetBooks');
    //Route::get('books-search', 'BookApiController@fetchBySearch');
});
