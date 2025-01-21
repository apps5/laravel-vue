<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShipsController;
use App\Http\Controllers\ShipsGalleryController;
use App\Http\Controllers\CabinCategoriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::get('/ships', [ShipsController::class, 'index']);
Route::apiResources([
  'ships' => ShipsController::class,
]);
Route::apiResources([
  'shipsgallery' => ShipsGalleryController::class,
]);
Route::apiResources([
  'cabincategories' => CabinCategoriesController::class,
]);



Route::get('/login', function () {
  return response()->json(['error' => 'Unauthenticated'], 401);
})->name('login');
