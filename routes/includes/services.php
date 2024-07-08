<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;

Route::resource('servicios', ServicesController::class)->except(['edit','show','create'])->names('services')->middleware(['auth', 'verified']);
Route::get('get-services', [ServicesController::class,'getAll'])->name('services.all');