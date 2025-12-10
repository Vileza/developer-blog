<?php

use App\Http\Controllers\Content\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'searchList']);
Route::get('/posts/{post}', [PostController::class, 'searchModel']);

Route::group(['prefix' => 'readers'], function (){
    
});