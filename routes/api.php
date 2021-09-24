<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Comment\CommentController;
use App\Http\Controllers\API\V1\Post\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);
Route::get('/v1/posts', [PostController::class, 'index']);
Route::get('/v1/posts/{post}', [PostController::class, 'show']);
Route::get('/v1/posts/{post}/comments', [CommentController::class , 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/v1/logout', [AuthController::class, 'logout']);
    Route::resource('/v1/posts', PostController::class)->except(['show', 'edit', 'create']);
    Route::post('/v1/posts/{post}/comments', [CommentController::class , 'store']);

});
