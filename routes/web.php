<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TcgController;
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

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', [AuthController::class, 'index']);

Route::get('/registration', [AuthController::class, 'registration']);
Route::post('/registration', [AuthController::class, 'createRegistration']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('web')->prefix('admin')->group(function () {
    Route::resource('/tcg', TcgController::class);
    Route::post('/tcg/get-data-tcg', [TcgController::class, 'get_data_tcg']);

});
