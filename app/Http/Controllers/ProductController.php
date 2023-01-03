<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        return view('products', [
            'products' => Product::latest()->paginate(20)
        ]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        $stripe = new StripeClient(config('app.stripe'));
        $result = $stripe->products->create([
            'name' => $request->name,
        ]);
        Product::create([
            'name' => $request->name,
            'stripe_id' => $result['id']
        ]); 
        return back()->with('success', 'Product has been created!');
    }

    public function update(Request $request, $product_id){
        $stripe = new StripeClient(config('app.stripe'));
        $stripe->products->update(
            $product_id,
            [
                'name' => $request->name,
            ]
        );

        Product::where('stripe_id', $product_id)->update([
            'name' => $request->name,
            'is_at' 
        ]);

        return back()->with('success', 'Product has been updated!');
    }
}