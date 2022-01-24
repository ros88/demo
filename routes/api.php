<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Models\Article;

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

Route::prefix('/v1')->group(function() {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/articles', ArticleController::class, ['except' => 'update']);
        Route::post('/articles/{article_id}', [ArticleController::class, 'update']);
        Route::apiResource('/comments', CommentController::class, ['only' => ['index', 'show', 'store']]);
        Route::post('/comments', [CommentController::class, 'store']);
        Route::delete('/comments/{comment_id}', [CommentController::class, 'destroy']);
    });

    Route::get('/unauthorized', function() {
        return response([
            'message' => 'unauthorized'
        ], 401);
    })->name('unauthorized');

    Route::get('/test', function() {
        return Article::with(['themes'])->get();
    });
});