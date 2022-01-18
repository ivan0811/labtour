<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapingController;

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

// Route::get('/scraping', [ScrapingController::class, 'storeWilayah']);
// Route::get('/tour', [ScrapingController::class, 'tour']);
// Route::get('/nav-tour', [ScrapingController::class, 'navigationTour']);
// Route::get('/store-tour', [ScrapingController::class, 'storeTour']);