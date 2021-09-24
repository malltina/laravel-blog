<?php

use App\Http\Controllers\api\v1\AuthenticationController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    
    Route::get('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('logout', [AuthenticationController::class, 'logout']);

        //Post routes
        Route::get('posts', [PostController::class, 'index']);
        Route::post('posts', [PostController::class, 'store']);
        Route::get('posts/{post}', [PostController::class, 'show']);
        Route::put('posts/{post}', [PostController::class, 'update']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);

        // Comment routes
        Route::post('posts/{post}/comments', [CommentController::class, 'store']);
        Route::get('posts/{post}/comments', [CommentController::class, 'show']);
        
    });
});
