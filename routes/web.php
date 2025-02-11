<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::resource('/data-peserta', PesertaController::class);
    Route::post('/data-peserta/get-data-users', [PesertaController::class, 'get_data_users']);

    Route::resource('/data-admin', AdminController::class);
    Route::get('/data-admin/{type}/{id}', [AdminController::class, 'show']);
    Route::post('/data-admin/get-data-admin', [AdminController::class, 'get_data_admin']);
});
