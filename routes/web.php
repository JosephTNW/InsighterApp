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
})->name('home');

Route::post('/', [InsightController::class, 'scrapTokopedia'])->name('scrapTokopedia');

Route::get('/history', [InsightController::class, 'getScrapHistory'])->name('getScrapHistory');

Route::get('/history/{instance_id}', [InsightController::class, 'getScrapData'])->name('getScrapData');

Route::get('/back', function () {
    // Check if the user is authenticated
    $authenticated = auth()->check();

    // Redirect the user back to the previous page
    return back()->with('authenticated', $authenticated);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    Route::post('/save-csv', [InsightController::class, 'saveCsvToDatabase'])->name('save_csv_to_database');
});
