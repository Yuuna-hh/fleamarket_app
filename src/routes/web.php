<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;

Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth', 'unverified.redirect');
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'unverified.redirect']);
Route::post('/mypage/profile', [ProfileController::class, 'update'])->middleware(['auth', 'unverified.redirect']);

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])->middleware('auth', 'unverified.redirect')->name('items.like.toggle'); //未ログイン時はいいねクリックでログインリダイレクト
Route::post('/item/{item}/comment', [ItemController::class, 'storeComment'])->middleware('auth', 'unverified.redirect') ->name('items.comments.store'); //未ログイン時はコメント送信ボタンでログインリダイレクト

Route::get('/sell', [SellController::class, 'create'])->middleware('auth', 'unverified.redirect');
Route::post('/sell', [SellController::class, 'store'])->middleware('auth', 'unverified.redirect');

Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');

Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->middleware('auth', 'unverified.redirect')->name('purchase.show');
Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->middleware('auth', 'unverified.redirect');


Route::get('/purchase/address/{item}', [PurchaseAddressController::class, 'edit'])->middleware('auth', 'unverified.redirect');
Route::post('/purchase/address/{item}', [PurchaseAddressController::class, 'update'])->middleware('auth', 'unverified.redirect');
Route::patch('/purchase/address/{item}', [PurchaseAddressController::class, 'update'])->name('purchase.address.update');


