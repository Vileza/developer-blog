<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/', [AuthenticateController::class, 'generateToken']);
});