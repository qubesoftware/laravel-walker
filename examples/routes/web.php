<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('walker', [App\Http\Controllers\WalkerController::class, 'show']);

Route::post('walker/next', [App\Http\Controllers\WalkerController::class, 'next']);

Route::post('walker/previous', [App\Http\Controllers\WalkerController::class, 'previous']);