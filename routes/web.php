<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BorrowsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login')->middleware('guest');
Route::get('/home', 'AuthController@home')->middleware('guest');
Route::get('/register', 'UserController@create')->middleware('guest'); //page for show register
Route::post('/register', 'UserController@store')->middleware('guest'); //for proccess register action

// Route::get('/admindashboard', 'AdminController@index')->middleware('auth')->name('admin');
// Route::get('/userdashboard', 'UserController@index')->middleware('auth');


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/register', 'UserController@create')->middleware('guest');
    Route::get('/logout', 'AuthController@logout')->middleware('auth');
    Route::get('/book', 'BooksController@index');
    Route::get('/setting', 'UserController@edit');
    Route::post('/setting', 'UserController@update');
    Route::get('/changepassword', 'AuthController@changepassword');
    Route::post('/changepassword', 'AuthController@updatepassword');
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/admindashboard', 'AdminController@index')->name('admin');
        // Route::get('/book', 'BooksController@index');
        Route::get('/book/addbook', 'BooksController@create');
        Route::post('/book', 'BooksController@store');
        Route::get('/book/changebook/{book}', 'BooksController@edit');
        Route::post('/book/changebook/{book}', 'BooksController@update');
        Route::post('/book/{book}', 'BooksController@confirmdelete');

        Route::get('/borrowedbook', 'BorrowsController@borrowed_book');
        Route::post('/borrowedbook', 'BorrowsController@store');

        Route::get('/reportborrowedbook', 'BorrowsController@index');

        Route::get('/returnedbook', 'ReturnsController@index');
        Route::post('/returnedbook', 'ReturnsController@store');
        // Route::get('/returnedbook', 'ReturnsController@findreturned_book');

        Route::get('/requestedbook', 'RequestsController@confirm');
        Route::post('/requestedbook', 'RequestsController@change');

        Route::get('/reportrequestbook', 'RequestsController@index');

        Route::get('/user', 'UserController@show');
        Route::post('/userdelete/{user}', 'UserController@destroy');
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/userdashboard', 'UserController@index');

        Route::get('/requestbook', 'UserController@requestbook');
        Route::get('/requestbook/applyrequest/{book}', 'RequestsController@requestbook');
        Route::post('/requestbook/applyrequest', 'RequestsController@store');

        Route::get('/requestbook/info/{request}', 'RequestsController@show');

        Route::get('/history', 'UserController@history');
    });
});
