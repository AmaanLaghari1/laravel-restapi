<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/store', [APIController::class, 'store']);



Route::get('/get', function(){
    return response()->json("Worked...", 200);
});

Route::post('/get', function(){
    return response()->json("Worked...", 200);
});


