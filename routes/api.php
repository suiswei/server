<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function (Request $request) {
    return response()->json([
        'name' => 'Jaspher Lloyd Tadlan',
        'section' => 'BSCS 601',
        'fav_song' => 'Here Without You'
    ]);
});
