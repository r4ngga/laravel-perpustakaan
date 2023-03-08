<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\BorrowsController;
use App\Http\Controllers\User\RequestsController;
use App\Http\Controllers\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth as Authentication; // because conflict with Illuminate\Support\Facades\Auth
use App\Http\Controllers\Admin;

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

Route::get('/login', [Authentication\AuthController::class, 'index'])->name('login');
Route::post('/login', [Authentication\AuthController::class, 'login'])->middleware('guest');
Route::get('/home', [Authentication\AuthController::class, 'home']);
Route::get('/register', [Admin\UserController::class, 'create'])->middleware('guest'); //page for show register
Route::post('/register', [Admin\UserController::class, 'store'])->middleware('guest'); //for proccess register action

// Route::get('/admindashboard', 'AdminController@index')->middleware('auth')->name('admin');
// Route::get('/userdashboard', 'UserController@index')->middleware('auth');


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/register', 'UserController@create')->middleware('guest');
    Route::get('/logout', [Authentication\AuthController::class, 'logout'])->middleware('auth');
    Route::get('/book', [Admin\BooksController::class, 'index']);
    Route::get('/setting', [UserController::class, 'edit']);
    Route::post('/setting', [UserController::class, 'update']);
    Route::get('/changepassword', [Authentication\AuthController::class, 'changepassword']);
    Route::post('/changepassword', [Authentication\AuthController::class, 'updatepassword']);
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/admindashboard', 'AdminController@index')->name('admin');
        // Route::get('/book', 'BooksController@index');
        Route::get('/book/addbook', [Admin\BooksController::class, 'create']);
        Route::post('/book', [Admin\BooksController::class, 'store']);
        Route::get('/book/changebook/{book}', [Admin\BooksController::class, 'edit']);
        Route::post('/book/changebook/{book}', [Admin\BooksController::class, 'update']);
        Route::post('/book/{book}', [Admin\BooksController::class, 'confirmdelete']);

        Route::get('/borrowedbook', [Admin\BorrowsController::class, 'borrowed_book']);
        Route::post('/borrowedbook', [Admin\BorrowsController::class, 'store']);

        Route::get('/reportborrowedbook', [BorrowsController::class, 'index']);

        Route::get('/returnedbook', [ReturnsController::class, 'index']);
        Route::post('/returnedbook', [ReturnsController::class, 'store']);
        // Route::get('/returnedbook', 'ReturnsController@findreturned_book');

        Route::get('/requestedbook', [RequestsController::class, 'confirm']);
        Route::post('/requestedbook', [RequestsController::class, 'change']);

        Route::get('/reportrequestbook', [RequestsController::class, 'index']);

        Route::get('/user', [UserController::class, 'show']);
        Route::post('/userdelete/{user}', [UserController::class, 'destroy']);
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/userdashboard', [User\UserController::class, 'index']);

        Route::get('/requestbook', [User\UserController::class, 'requestbook']);
        Route::get('/requestbook/applyrequest/{book}', [User\RequestsController::class, 'requestbook']);
        Route::post('/requestbook/applyrequest', [User\RequestsController::class, 'store']);

        Route::get('/requestbook/info/{request}', [User\RequestsController::class, 'show']);

        Route::get('/history', [User\UserController::class, 'history']);
    });
});
