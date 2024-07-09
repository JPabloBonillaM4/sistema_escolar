<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareersController;

Route::resource('carreras', CareersController::class)->except(['edit','show','create'])->names('careers')->middleware(['auth', 'verified']);
Route::get('get-careers', [CareersController::class,'getAll'])->name('careers.all');