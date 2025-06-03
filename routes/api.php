<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// ini dibikin middleware untuk si kucing

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/getAllUser', [UserController::class, 'getAllUser']);
    Route::post('/addUser', [UserController::class, 'addUser']);
    Route::get('/users/{id}', [UserController::class, 'getOneUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});
