<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodsController;

Route::resource('periodos', PeriodsController::class)->except(['edit','show','create'])->names('periods');
Route::get('get-periods', [PeriodsController::class,'getAll'])->name('periods.all');
