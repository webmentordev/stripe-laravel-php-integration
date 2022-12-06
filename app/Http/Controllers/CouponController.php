<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Currency;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
        return view('coupon', [
            'currency' => Currency::all(),
            'coupons' => Coupon::latest()->paginate(20)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'percent' => 'required|numeric',
            'currency' => 'required',
            'code' => 'required|unique:coupons,code',
            'max' => 'required|numeric',
        ]);

        $stripe = new StripeClient(config('app.stripe'));

        $coupon = $stripe->coupons->create([
            'percent_off' => $request->percent,
            'name' =>  $request->percent."% off",
            'currency' => $request->currency
        ]);

        $promo = $stripe->promotionCodes->create([
            'coupon' => $coupon['id'],
            'code' => strtoupper($request->code),
            "max_redemptions" => $request->max
        ]);


        Coupon::create([
            'coupon_id' => $coupon['id'],
            'coupon_name' => $request->percent."% off",
            'currency' => $request->currency,
            'precent' => $request->percent,
            'promo_id' => $promo['id'],
            'code' => strtoupper($request->code),
            'max' => $request->max,
        ]);

        return back()->with('success', 'Coupon and Promo Code Generated!');
    }
}
