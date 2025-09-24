<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/ping', fn () => response()->json(['pong' => true]));

Route::apiResource('posts', PostController::class)->only(['index','store', 'update', 'show', 'destroy']);

/* 댓글 라우트: 부모(post) 하에 index/store, 나머지는 얕은(shallow) 경로 */
Route::apiResource('posts.comments', CommentController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->shallow();