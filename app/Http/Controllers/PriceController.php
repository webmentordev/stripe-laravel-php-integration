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
}