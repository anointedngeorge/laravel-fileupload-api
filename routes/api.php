<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileuploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [AuthController::class, 'index']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);


// prevents unauthorized access
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/upload', FileUploadController::class);
});