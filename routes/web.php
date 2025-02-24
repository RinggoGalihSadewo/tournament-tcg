<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TcgController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentParticipantController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeckLogController;

use App\Http\Controllers\ClientController;

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

// Cliean
Route::get('/', [ClientController::class, 'index']);
Route::get('/login', [AuthController::class, 'view_login_client']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/registration', [AuthController::class, 'view_registration_client']);
Route::post('/registration', [AuthController::class, 'create_registration_client']);

Route::get('/tournaments', [TournamentController::class, 'view_tournament_client']);
Route::post('/tournaments/search', [TournamentController::class, 'search_tournament']);
Route::post('/tournaments', [TournamentParticipantController::class, 'regis_tournament_client']);

Route::get('/my-events', [TournamentController::class, 'view_my_events_client']);

Route::resource('/deck-log', DeckLogController::class);

Route::get('/my-profile', [AuthController::class, 'view_my_profile_client']);
Route::patch('/my-profile', [AuthController::class, 'update_my_profile_client']);

// Admin
Route::get('/login-admin', [AuthController::class, 'index'])->name('login');

Route::get('/registration-admin', [AuthController::class, 'registration']);
Route::post('/registration-admin', [AuthController::class, 'create_registration']);

Route::post('/login-admin', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('web')->prefix('admin')->group(function () {
    Route::resource('/tcg', TcgController::class);
    Route::post('/tcg/get-data-tcg', [TcgController::class, 'get_data_tcg']);

    Route::get('/tournament/add', [TournamentController::class, 'create']);
    Route::post('/tournament/get-data-tournament', [TournamentController::class, 'get_data_tournament']);
    Route::resource('/tournament', TournamentController::class);
    
    Route::get('/tournament-participants/pairing', [TournamentParticipantController::class, 'pairing_view']);
    Route::post('/tournament-participants/pairing/get-participant-by-tournament', [TournamentParticipantController::class, 'get_participant_by_tournament']);
    Route::post('/tournament-participants/pairing/save-pairing', [TournamentParticipantController::class, 'save_pairing']);
    Route::resource('/tournament-participants', TournamentParticipantController::class);
    Route::post('/tournament-participants/get-data-tournament-participant', [TournamentParticipantController::class, 'get_data_tournament_participant']);

    Route::get('/report/download-pdf/{id_tournament}', [ReportController::class, 'download_pdf']);
    Route::post('/report/get-data-report', [ReportController::class, 'get_data_report']);
    Route::post('/report/get-data-report-filter', [ReportController::class, 'get_data_report_filter']);
    Route::resource('/report', ReportController::class);
});
