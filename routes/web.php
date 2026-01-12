<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\InquiryController;

Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/voitures', [CarController::class, 'index'])->name('cars.index');
Route::get('/voitures/{slug}', [CarController::class, 'show'])->name('cars.show');
Route::get('/search', [CarController::class, 'search'])->name('cars.search');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
