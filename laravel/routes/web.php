<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
  return view('welcome'); // The main Blade template with Vue SPA
})->where('any', '.*');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/user/login', function () {
  return view('welcome');
});