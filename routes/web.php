<?php

use App\Http\Controllers\AuthController;
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

// Protected Route
Route::inertia('/', 'Dashboard')
    ->middleware('auth')
    ->name('dashboard');

// Auth
Route::get('/login/google', [AuthController::class, 'redirectToProvider']);

Route::get('/login/google/callback', [AuthController::class, 'handleProviderCallback']);

Route::inertia('/login', 'Login')
    ->name('login');

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
