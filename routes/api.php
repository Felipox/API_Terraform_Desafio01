<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


//Register
Route::prefix('auth')->group(function () {
route::post('/register', [AuthController::class,'register']);
route::post('/login', [AuthController::class,'login']);
route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
});
//User
Route::get('/me',[UserController::class, 'index'])->middleware('auth:sanctum');

//Post
route::post('/posts',[PostsController::class, 'create'])->middleware('auth:sanctum');
route::get('/posts',[PostsController::class, 'index'])->middleware('auth:sanctum');
route::get('/posts/{id}',[PostsController::class, 'show'])->middleware('auth:sanctum');
route::put('/posts/{id}',[PostsController::class, 'update'])->middleware('auth:sanctum');
route::delete('/posts/{id}',[PostsController::class, 'delete'])->middleware('auth:sanctum');
route::patch('/posts/{id}/archive',[PostsController::class, 'archivePost'])->middleware('auth:sanctum');

//Comments
route::post('/posts/{id}/comments',[CommentsController::class,'create'])->middleware('auth:sanctum');
route::get('/posts/{id}/comments',[CommentsController::class,'index'])->middleware('auth:sanctum');
route::delete('/comments/{id}',[CommentsController::class,'delete'])->middleware('auth:sanctum');
