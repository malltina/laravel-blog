<?php

use App\Http\Controllers\api\v1\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::get('/register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthenticationController::class, 'logout']);
    });
});
