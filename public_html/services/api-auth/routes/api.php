<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([], function(){
    Route::post('/', [AuthenticateController::class, 'generateToken']);
});