<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    
    public function store(Request $request, Product $product)
    {
        if (auth()->user()->can('like',$product)) {
            $product->like();
        } else {
            abort(401);
        }
    }


    public function destroy(Request $request, Product $product)
    {
        if (auth()->user()->can('unlike',$product)) {
            $product->unlike();
        } else {
            abort(401);
        }
    }
}
