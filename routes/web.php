<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\PeriodsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/includes/general.php';
require __DIR__.'/auth.php';
/** SERVICES */
require __DIR__.'/includes/services.php';
/** CAREERS */
require __DIR__.'/includes/careers.php';

Route::resource('materias', SubjectsController::class)->names('subjects');

Route::resource('periodos', PeriodsController::class)->names('periods');
