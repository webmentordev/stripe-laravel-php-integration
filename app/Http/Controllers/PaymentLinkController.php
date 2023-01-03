<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Stripe\StripeClient;
use App\Models\PaymentLink;
use Illuminate\Http\Request;

class PaymentLinkController extends Controller
{
    public function index(){
        return view('payments', [
            'price' => Price::all(),
            'payments' => PaymentLink::latest()->with('price')->paginate(20)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'price' => 'required|unique:payment_links,price_id',
            'quantity' => 'required|numeric'
        ]);
        $stripe = new StripeClient(config('app.stripe'));
        $result = $stripe->paymentLinks->create([
            'line_items' => [
                [
                    'price' => $request->price,
                    'quantity' => $request->quantity
                ],
            ],
            'allow_promotion_codes' => true
        ]);
        PaymentLink::create([
            'price_id' => $request->price,
            'quantity' => $request->quantity,
            'url' => $result['url']
        ]);
        return back()->with('success', 'Payment Link has been generated');
    }
}