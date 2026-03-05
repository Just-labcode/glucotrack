<?php

use App\Http\Controllers\BloodSugarReadingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('readings.index'));

Route::resource('readings', BloodSugarReadingController::class);