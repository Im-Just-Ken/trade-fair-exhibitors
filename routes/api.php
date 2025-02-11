<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExhibitorController;

Route::get('/exhibitors', [ExhibitorController::class, 'index']);
Route::get('/exhibitors/search', [ExhibitorController::class, 'search']);
Route::get('/exhibitors/{id}', [ExhibitorController::class, 'show']);
Route::post('/exhibitors', [ExhibitorController::class, 'store']);
Route::patch('/exhibitors/{id}', [ExhibitorController::class, 'update']);
Route::delete('/exhibitors/{id}', [ExhibitorController::class, 'destroy']);

