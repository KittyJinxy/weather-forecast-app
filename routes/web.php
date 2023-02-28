<?php

use App\Http\Controllers\WeatherForecastController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('weather');
});


// Section for the weather forecast

Route::group(['prefix' => 'weather'], function () {
    Route::get('/', [WeatherForecastController::class, 'index'])->name('weather');
    
});
