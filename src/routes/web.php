<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoverController;

Route::get('/', function () {
    return view('welcome.main');
});

Route::resource('rover', RoverController::class);

Route::post('rover/clear-session', [RoverController::class, 'clearSession'])->name('rover.clear-session');
