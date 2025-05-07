<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome.main');
});

use App\Http\Controllers\RoverController;
Route::resource('rover', RoverController::class);
