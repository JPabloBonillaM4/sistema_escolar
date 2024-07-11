<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectsController;

Route::resource('materias', SubjectsController::class)->except(['edit','show','create'])->names('subjects')->middleware(['auth', 'verified']);
Route::get('get-subjects', [SubjectsController::class,'getAll'])->name('subjects.all');