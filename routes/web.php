<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/loginCheck', [LoginController::class, 'loginCheck'])->name('loginCheck');



Route::group(['middleware' => 'jwt.auth'], function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard/{token}', [DashboardController::class, 'dashboard'])->name('dashboard');


});

// Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('jwt.auth');
