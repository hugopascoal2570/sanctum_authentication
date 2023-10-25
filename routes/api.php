<?php 
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

});