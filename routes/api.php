<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/post', [APIController::class, 'store']);

Route::get('/get', [APIController::class, 'index']);

Route::get('/get/{id}', [APIController::class, 'show']);

Route::put('/update/{id}', [APIController::class, 'update']);

Route::delete('/delete/{id}', [APIController::class, 'destroy']);

Route::put('/change-pass/{id}', [APIController::class, 'changePassword']);