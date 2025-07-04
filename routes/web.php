<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', function ($token) {
    return response()->json([
        'message' => 'This is a dummy reset-password route.',
        'token' => $token
    ]);
})->name('password.reset');
