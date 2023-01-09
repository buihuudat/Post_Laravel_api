<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Models\Comment;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/user', [AuthController::class, 'user']);
  Route::post('/user', [AuthController::class, 'update']);
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::resource('post', PostController::class);

  Route::get('/comment/{id}', [CommentController::class, 'index']);
  Route::post('/comment/{id}', [CommentController::class, 'store']);
  Route::put('/comment/{id}', [CommentController::class, 'update']);
  Route::delete('/comment/{id}', [CommentController::class, 'destroy']);

  Route::post('/post/{id}/like', [LikeController::class, 'likeOrUnlike']);
});
