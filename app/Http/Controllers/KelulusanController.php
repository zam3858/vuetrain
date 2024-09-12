<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelulusanController extends Controller
{
    // dapatkan senarai user yang perlu diluluskan
    public function index() {   
        return User::where('status', User::STATUS_BARU)
            ->get();
    }

    // dapatkan user
    public function getUser($id) {
        return User::findOrFail($id);
    }

    // proses kelulusan
    public function process($id) {

        request()->validate([
            'status' => 'required',
        ]);
        
        $user = User::findOrFail($id);
        $user->status = request()->status;
        $user->remark = request()->remark ?? '';
        $user->save();

        return ['success'];
    }
}
