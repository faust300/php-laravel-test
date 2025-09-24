<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/ping', fn () => response()->json(['pong' => true]));

// 지금은 index, store만
Route::apiResource('posts', PostController::class)->only(['index','store', 'update', 'show', 'destroy']);