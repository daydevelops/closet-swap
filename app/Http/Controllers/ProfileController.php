<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $user) {
        $products = $user->products()
        ->select('id','title','user_id','category_id','description','size','tags')
        ->with(['photos','user:id,handle','category:id,name'])
        ->get();
        
        return view('profile.show',compact('user','products'));
    }
}
