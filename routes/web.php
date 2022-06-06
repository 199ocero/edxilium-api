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

Route::get('/', function () {
    // change the away url when deployed to real server
    return redirect()->away(env('FRONTEND_URL'));
    // return view('welcome');
});
Route::view('forgot_password', 'forgot.reset_password')->name('password.reset');
Route::get('/api/password/reset', function () {
    return view('error.invalid_token');
});
