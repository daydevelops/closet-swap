<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function settings(Request $request)
    {
        return view('profile.settings', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
