<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\StripeWebhookController;

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

// ユーザー認証前
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::get('/search', [ItemController::class, 'search']);

//
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

//stripe
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->name('stripe.webhook');

// ユーザー認証後
Route::middleware('auth')->group(function () {
    // 購入
    Route::get('/purchase/{item_id}', [OrderController::class, 'purchase']);
    Route::post('/purchase', [OrderController::class, 'create']);

    //アドレス変更
    Route::get('/purchase/address/{item_id}',[AddressController::class, 'edit']);
    Route::post('/purchase/address', [AddressController::class, 'create']);

    // 商品出品
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'create']);

    // マイページ
    Route::get('/mypage', [ProfileController::class, 'mypage']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);

    // プロフィール
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::post('/profile/edit', [ProfileController::class, 'create']);

    // 商品画面アクション
    Route::post('/like/{item_id}', [ItemController::class, 'like']);
    Route::post('/comment/{item_id}', [ItemController::class, 'comment']);

    //stripe
    Route::post('/purchase/{item}/checkout', [StripeCheckoutController::class, 'create'])
        ->name('checkout.create');
});