<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('users', function (Request $request) {
        return User::all();
    });
    
    Route::post('users', function (Request $request) {
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make('password');
        $user->created_by = auth()->user()->id;
    
        $user->save();
    
        return $user;
    });
    
    Route::put('users/{id}', function (Request $request, $id) {
        $request->validate([
            'email' => 'email',
        ]);
        
        $user = User::findOrFail($id);
        $user->name = request()->name;
        $user->email = request()->email;
    
        $user->save();
    
        return $user;
    });
    
    Route::delete('users/{id}', function ( Request $request, $id) {
        $user = User::findOrFail($id);
        $user->delete();
        return ['true'];
    });
    
    Route::get('users/{id}', function ( Request $request, $id) {
        $user = User::with('audits.user')->findOrFail($id);
        // dd($user->audits()->first()->old_values['name']);
        return $user;
    });
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
