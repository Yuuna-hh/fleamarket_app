<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/sell', [SellController::class, 'create'])->middleware('auth');
Route::post('/sell', [SellController::class, 'store'])->middleware('auth');

Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->middleware('auth');
Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->middleware('auth');

Route::get('/purchase/address/{item}', [PurchaseAddressController::class, 'edit'])->middleware('auth');
Route::post('/purchase/address/{item}', [PurchaseAddressController::class, 'update'])->middleware('auth');

Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth');

Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->middleware('auth');