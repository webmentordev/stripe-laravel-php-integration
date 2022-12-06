<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, $price){
        $this->validate($request, [
            'quantity' => 'required|min:1|max:500|numeric'
        ]);
        if($request->quantity >= 1 && $request->quantity <= 500){
            Cart::create([
                'price' => $price,
                'quantity' => $request->quantity
            ]);
            return back()->with('success', 'Product has been added!');
        }else{
            return back()->with('failed', 'Quantity is limited to 1 or more but less then 500');
        }
    }
    public function destroy(){
        Cart::truncate();
        return back()->with('success', 'Cart is now empty!');
    }
    public function checkout(){
        $stripe = new StripeClient(config('app.stripe'));
        $products = Cart::get();
        if(count($products) > 0){
            foreach($products as $item){
                $array[] = [ 'price' => $item->price, 'quantity' => $item->quantity ];
            }
            $checkout = $stripe->checkout->sessions->create([
                'success_url' => config('app.url').'/success',
                'cancel_url' => config('app.url').'/cancel',
                'line_items' => $array,
                'mode' => 'payment',
            ]);
            return redirect($checkout['url']);
        }else{
            abort(500, 'Internal Server Error');
        }
    }
}