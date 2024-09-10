<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// http://eaudit.test/api/users
Route::get('users', function (Request $request) {
    return User::all();
});

// http://eaudit.test/api/user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
