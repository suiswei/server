<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function (Request $request) {
    return response()->json([
        'name' => "Jan Brian C. Maturan",
        'section' => "BSCS601",
        'fav. song' => "truce"
        ]);
});
