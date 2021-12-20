<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;

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

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
