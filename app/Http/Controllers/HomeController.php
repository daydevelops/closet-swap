<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Exception\CardException;

class HomeController extends Controller
{
    public function home() {
        return view('home');
    }
    
    public function donate() {
        return view('donate.home');
    }

    public function success() {
        return view('donate.success');
    }

    public function process(Request $request) {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            \Stripe\Charge::create([
                'amount' => request('cost')*100,
                'currency' => 'cad',
                'source' => request('id')
            ]);
            return response()->json([
                'status'=>true,
                'cost'=>request('cost')
            ]);
        } catch (CardException $e) {
            return response()->json([
                'status'=>false
            ]);
        }
    }
}
