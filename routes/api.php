<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;


Route::get('/users', [UserController :: class, 'index']);

Route::get('/users/{id}', [UserController :: class, 'show']);

Route::post('/users', [UserController :: class, 'store']);

Route::put('/users/{id}', [UserController :: class, 'update'] );

Route::patch('/users/{id}', [UserController :: class, 'updatePartial'] );

Route::delete('/users/{id}',[UserController :: class, 'destroy']);


Route::get('/ventas', [VentaController::class, 'index']);
Route::post('/ventas', [VentaController::class, 'store']);