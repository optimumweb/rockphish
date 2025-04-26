<?php

use App\Http\Controllers\PhishController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
})->name('home');

Route::domain('{domain}')->name('phish.')->group(function () {
    Route::get('/open/{email}', [PhishController::class, 'opened'])->name('opened');
    Route::get('/hook/{email}', [PhishController::class, 'hooked'])->name('hooked');
});

Route::prefix('/')->group(function () {
    Route::get('/open/{email}', [PhishController::class, 'opened']);
    Route::get('/hook/{email}', [PhishController::class, 'hooked']);
});
