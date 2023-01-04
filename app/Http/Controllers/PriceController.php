<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Currency;
use App\Models\Price;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(){
        return view('price', [
            'currency' => Currency::all(),
            'products' => Product::all(),
            'price' => Price::latest()->with('product')->paginate(20)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'price' => 'required|numeric',
            'product' => 'required',
            'currency' => 'required'
        ]);
        if($request->price > 0){
            $stripe = new StripeClient(config('app.stripe'));
            $result = $stripe->prices->create([
                'unit_amount' => $request->price * 100,
                'currency' => $request->currency,
                'product' => $request->product,
            ]);
            Price::create([
                'price_id' =>  $result['id'],
                'price' =>  $request->price,
                'currency' =>  $request->currency,
                'stripe_id' =>  $request->product,
            ]);
            return back()->with('success', 'Price has been created!');
        }else{
            return back()->with('failed', 'Price must be greater then Zero');
        }
    }

    public function update(Request $request, $price_id){
        $this->validate($request, [
            'price' => 'required|numeric'
        ]);

        $stripe = new StripeClient(config('app.stripe'));

        $price_data = $stripe->prices->retrieve($price_id, []);

        $result = $stripe->prices->create(array_filter([
            'unit_amount' => $request->price * 100,
            'currency' => $request->currency != null ? $request->currency : $price_data['currency'],
            'product' => $price_data['product'],
        ]));

        $stripe->prices->update(
            $price_id,
            [ 
                'active' => false 
            ]
        );

        Price::where('price_id', $price_id)->update(array_filter([
            'price_id' => $result['id'],
            'price' => $request->price,
            'currency' => $request->currency
        ]));
        
        return back()->with('success', 'Price has been updated!');
        
    }
}