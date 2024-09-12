<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\KelulusanController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'create']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);
    Route::get('users/{id}', [UserController::class, 'edit']);

    Route::get('kelulusan', [KelulusanController::class, 'index']);
    Route::get('kelulusan/{id}', [KelulusanController::class, 'getUser']);
    Route::put('kelulusan/{id}', [KelulusanController::class, 'process']);

});

// http://eaudit.test/api/user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken('web')->plainTextToken;
});
