<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Admin\BooksController;
// use App\Http\Controllers\BorrowsController;
use App\Http\Controllers\User\RequestsController;
use App\Http\Controllers\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth as Authentication; // because conflict with Illuminate\Support\Facades\Auth
use App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserController;

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
Route::get('/home', [Authentication\AuthController::class, 'home'])->name('home');
Route::get('/register', [Authentication\AuthController::class, 'create'])->middleware('guest'); //page for show register
Route::post('/register', [Admin\UserController::class, 'store'])->middleware('guest'); //for proccess register action

Route::post('validation-phone-number', [Authentication\AuthController::class, 'validationPhoneNumber'])->name('validation-phone'); //checking phone_number
Route::post('validation-email', [Authentication\AuthController::class, 'validationEmail'])->name('validation-email'); //checking email

// Route::get('/admindashboard', 'AdminController@index')->middleware('auth')->name('admin');
// Route::get('/userdashboard', 'UserController@index')->middleware('auth');


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/register', 'UserController@create')->middleware('guest');
    Route::get('/logout', [Authentication\AuthController::class, 'logout'])->middleware('auth');
    Route::get('/book', [Admin\BooksController::class, 'index'])->name('book');
    Route::get('/setting', [User\UserController::class, 'edit'])->name('setting');
    Route::post('/setting', [User\UserController::class, 'update'])->name('setting.update');
    Route::get('/changepassword', [Authentication\AuthController::class, 'changepassword']);
    Route::post('/changepassword', [Authentication\AuthController::class, 'updatepassword']);
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('admin-dashboard', [Admin\AdminController::class, 'index'])->name('admin');
        Route::get('book', [Admin\BooksController::class, 'index'])->name('book');
        Route::get('book/create', [Admin\BooksController::class, 'create'])->name('book.create');
        Route::get('book/{id}', [Admin\BooksController::class, 'show'])->name('book.show');
        Route::post('book', [Admin\BooksController::class, 'store'])->name('book.store');
        // Route::get('book/edit/{id}', [Admin\BooksController::class, 'edit'])->name('book.edit');
        Route::post('book/update/{id}', [Admin\BooksController::class, 'update'])->name('book.update');
        // Route::get('/book/changebook/{book}', [Admin\BooksController::class, 'edit']);
        // Route::post('/book/changebook/{book}', [Admin\BooksController::class, 'update']);
        Route::post('/book/delete', [Admin\BooksController::class, 'confirmdelete'])->name('book.delete');
        Route::get('fetchbook', [Admin\BooksController::class, 'fetchIndex'])->name('book.fetch-index');
        Route::get('fetchedit/{id}', [Admin\BooksController::class, 'fetchEdit'])->name('book.fetch-edit');

        Route::get('borrowedbook', [Admin\BorrowsController::class, 'borrowed_book'])->name('borrowedbook');
        Route::post('borrowedbook', [Admin\BorrowsController::class, 'store'])->name('borrowedbook.store');

        Route::get('reportborrowedbook', [Admin\BorrowsController::class, 'index'])->name('report-borrowed-book');

        Route::get('returnedbook', [Admin\ReturnsController::class, 'index'])->name('returned-book');
        Route::post('returnedbook', [Admin\ReturnsController::class, 'store'])->name('returned-book.store');
        // Route::get('/returnedbook', 'ReturnsController@findreturned_book');

        Route::get('requestedbook', [Admin\RequestController::class, 'confirm'])->name('requested-book');
        Route::post('requestedbook', [Admin\RequestController::class, 'update'])->name('requested-book.change');

        Route::get('report-request-book', [Admin\RequestController::class, 'index'])->name('report-request-book');

        Route::get('users', [Admin\UserController::class, 'index'])->name('users');
        Route::post('users', [Admin\UserController::class, 'store'])->name('users.store');
        // Route::get('users/{id}', [Admin\UserController::class, 'fetchShow'])->name('users.show');
        Route::post('users/update', [Admin\UserController::class, 'update'])->name('users.update');
        // Route::get('/users', [Admin\UserController::class, 'show'])->name('users.show');
        // Route::get('/users/{id}', [Admin\UserController::class, 'fetchEdit'])->name('users.edit');
        Route::post('users/delete', [UserController::class, 'destroy'])->name('users.delete');

        //logs
        Route::get('logs', [Admin\LogController::class, 'index'])->name('logs');
        //Route::get('logs/{id}', [Admin\LogController::class, 'fetchDetail'])->name('logs.detail');
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/dashboard', [User\UserController::class, 'index'])->name('user');
        Route::get('books', [User\BookController::class, 'index'])->name('books');

        Route::get('/requestbook', [User\UserController::class, 'requestbook'])->name('request-book');
        Route::get('/requestbook/applyrequest/{book}', [User\RequestsController::class, 'requestbook']);
        Route::post('/requestbook/applyrequest', [User\RequestsController::class, 'store']);

        Route::get('/requestbook/info/{request}', [User\RequestsController::class, 'show']);

        Route::get('history', [User\HistoryController::class, 'index'])->name('history');
    });
});
