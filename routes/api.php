<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\IslandsController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\TourController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'show']);
        Route::post('/', [CommentController::class, 'store']);
        Route::patch('/{id}', [CommentController::class, 'update']);
        Route::delete('/{id}', [CommentController::class, 'delete']);
    });    

    Route::prefix('search')->group(function () {
        Route::get('/', [SearchController::class, 'searchTour']);
        // Route::post('/', [SearchController::class, 'store']);
        // Route::patch('/{id}', [SearchController::class, 'update']);
        // Route::delete('/{id}', [SearchController::class, 'delete']);
    });    

    Route::prefix('islands')->group(function () {
        Route::get('/', [IslandsController::class, 'show']);
        Route::post('/', [IslandsController::class, 'store']);
        Route::patch('/{id}', [IslandsController::class, 'update']);
        Route::delete('/{id}', [IslandsController::class, 'delete']);
    });

    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'show']);
        Route::post('/', [ProvinceController::class, 'store']);
        Route::patch('/{id}', [ProvinceController::class, 'update']);
        Route::delete('/{id}', [ProvinceController::class, 'delete']);
    });
    
    Route::prefix('cities')->group(function () {
        Route::get('/', [CitiesController::class, 'show']);
        Route::get('/tour', [CitiesController::class, 'showCitiesTour']);
        Route::get('/tour-by-id/{id}', [CitiesController::class, 'showCitiesTourById']);
        Route::post('/', [CitiesController::class, 'store']);
        Route::patch('/{id}', [CitiesController::class, 'update']);
        Route::delete('/{id}', [CitiesController::class, 'delete']);
    });

    Route::prefix('tour')->group(function () {
        Route::get('/', [TourController::class, 'show']);
        Route::post('/', [TourController::class, 'store']);
        Route::patch('/{id}', [TourController::class, 'update']);
        Route::delete('/{id}', [TourController::class, 'delete']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
