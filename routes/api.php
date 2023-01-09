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

  Route::controller(AuthController::class)->group(
    function () {
      Route::get('/user', 'user');
      Route::post('/user', 'update');
      Route::post('/logout', 'logout');
    }
  );

  Route::resource('post', PostController::class);

  Route::controller(CommentController::class)->group(
    function () {
      Route::prefix('comment')->group(
        function () {
          Route::get('/{id}', 'index');
          Route::post('/{id}', 'store');
          Route::put('/{id}', 'update');
          Route::delete('/{id}', 'destroy');
        }
      );
    }
  );

  Route::post('/post/{id}/like', [LikeController::class, 'likeOrUnlike']);
});
