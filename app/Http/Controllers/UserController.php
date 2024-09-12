<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {   
        return User::all();
    }

    public function create(Request $request)
    {
        if ( !auth()->user()->can('edit users') ) {
            return response([ 'status' => 'access denied' ], 401);
        }

        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make('password');
        $user->created_by = auth()->user()->id;
    
        $user->save();
    
        return $user;
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'email',
        ]);
        
        $user = User::findOrFail($id);
        $user->name = request()->name;
        $user->email = request()->email;
    
        $user->save();
    
        return $user;
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['true'];
    }

    public function edit(Request $request, $id)
    {
        $user = User::with('audits.user')->with('roles.permissions')->findOrFail($id);
        // dd($user->audits()->first()->old_values['name']);
        return $user;
    }
}
