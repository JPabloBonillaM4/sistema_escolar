<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::get('/', [GeneralController::class,'index'])->name('index');
Route::get('/dashboard', [GeneralController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');