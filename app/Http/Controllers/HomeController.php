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
        $data = $request->validate([
            'cost' => 'required|numeric|min:0.5',
            'id' => 'required'
        ]);
        $cost_cents = $data['cost'] * 100; 
        $cost_cad = $data['cost'];

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            \Stripe\Charge::create([
                'amount' => $cost_cents,
                'currency' => 'cad',
                'source' => $data['id']
            ]);

            if (auth()->check()) {
                $user = auth()->user();
                $current_donations = $user->donations;
                $user->update([
                    'donations' => $current_donations + $cost_cad
                ]);
            }

            return redirect(route('successful-donation'));

        } catch (CardException $e) {
            return response()->json([
                'status'=>false
            ]);
        }
    }
}
