<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthenticationController;

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

Route::group(['prefix' => 'v1'], function () {

    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/signin', [AuthenticationController::class, 'signin']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/profile', function (Request $request) {
            return auth()->user();
        });
        Route::post('/sign-out', [AuthenticationController::class, 'logout']);
    });
});
//Post
Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::put('posts/{post}', [PostController::class, 'update']);
Route::delete('posts/{post}', [PostController::class, 'destroy']);

// Comment routes
Route::post('posts/{post}/comments', [CommentController::class, 'postcomment']);

