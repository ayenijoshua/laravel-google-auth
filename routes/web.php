<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('google-auth', [GoogleLoginController::class, 'signIn'])->name('google-auth');
Route::get('callback', [GoogleLoginController::class, 'callback']);
Route::get('user', [GoogleLoginController::class, 'user']);
