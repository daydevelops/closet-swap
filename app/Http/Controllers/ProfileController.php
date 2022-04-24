<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $user) {
        $products = $user->products()->select('id','title')->get();
        return view('profile.show',compact('user','products'));
    }
}
