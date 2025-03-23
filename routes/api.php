<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Jobs\ProcessProdcast;

use App\Http\Controllers\AuthController;
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


  Route::middleware('api.key')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
  Route::middleware('auth:api')->group(function () {

    Route::get('/users', [UserController::class, 'getAllUsers']);
//for the queue 
    Route::get('/users/status/{status}/ids', [UserController::class, 'getUserIdsByStatus']);
//for the job
Route::get('/users/status-zero/update', function () {
  ProcessProdcast::dispatch();
  return response()->json([
      'message' => 'Job dispatched to update users with status = 0.'
  ]);
});
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::post('/users', [UserController::class, 'addUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/unlock-account', [AuthController::class, 'unlockAccount'])->middleware('auth:api');
});
