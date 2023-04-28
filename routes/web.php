<?php

use App\Http\Controllers\InsightController;
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
});

Route::get('/original', function () {
    return view('welcome');
});

Route::post('/', [InsightController::class, 'scrapTokopedia'])->name('scrapTokopedia');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/save', [InsightController::class, 'saveToDatabase'])->name('saveToDatabase');
});
