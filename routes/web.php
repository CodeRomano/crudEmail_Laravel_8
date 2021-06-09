<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AuditController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/country/{country_id}/states', [StateController::class, 'getStatesByCountry'])->name('getStatesByCountry');
Route::get('/state/{state_id}/city', [CityController::class, 'getCitiesByState'])->name('getCitiesByState');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('audit', [AuditController::class, 'index'])->name('audit.index');
    Route::post('users-data/action', [UserController::class, 'action'])->name('users-data.action');
    Route::get('emails', [EmailController::class, 'index'])->name('email.index');
    Route::get('email/create', [EmailController::class, 'create'])->name('email.create');
    Route::post('email/send', [EmailController::class, 'send'])->name('email.send');
});
    
