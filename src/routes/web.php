<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('login');
Route::get('/item/{item_id}', [ItemController::class, 'item']);

Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [ItemController::class, 'item']);
    Route::get('/purchase/address/i{tem_id}', [ItemController::class, 'item']);
    Route::get('/sell', [ItemController::class, 'item']);
    Route::get('/mypage', [ItemController::class, 'item']);
    Route::get('/mypage/profile', [ItemController::class, 'item']);
    });