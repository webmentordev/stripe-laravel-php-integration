<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Currency;
use App\Models\Invoice;
use Stripe\StripeClient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        return view('invoices', [
            'products' => Product::latest()->get(),
            'currency' => Currency::latest()->get(),
            'invoices' => Invoice::latest()->paginate(20)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'product' => 'required',
            'currency' => 'required',
            'email' => 'required|email',
            'price' => 'required|numeric',
            'expire' => 'required|numeric'
        ]);

        $stripe = new StripeClient(config('app.stripe'));

        $price = $stripe->prices->create(
            [
              'product' => $request->product,
              'unit_amount' => $request->price * 100,
              'currency' => $request->currency,
            ]
        );

        $customer = $stripe->customers->create(
            [
              'name' => $request->name,
              'email' => $request->email,
              'description' => 'Invoice Level Customer',
            ]
        );


        $stripe->invoiceItems->create(
            [
                'customer' => $customer['id'], 
                'price' => $price['id'],
                'quantity' => 2
            ]
        );

        $init_invoice = $stripe->invoices->create(
            [
              'customer' => $customer['id'],
              'collection_method' => 'send_invoice',
              'days_until_due' => $request->expire,
              'auto_advance' => false,
              'pending_invoice_items_behavior' => 'include'
            ]
        );

        $stripe->invoices->finalizeInvoice($init_invoice['id'], []);
        
        $sent = $stripe->invoices->sendInvoice($init_invoice['id'], []);


        Invoice::create([
            'product_id' => $request->product,
            'price_id' => $price['id'],
            'name' => $request->name,
            'email' => $request->email,
            'customer_id' => $customer['id'],
            'invoice_id' => $init_invoice['id'],
            'currency' => $request->currency,
            'expire' => $request->expire,
            'price' => $request->price,
            'url' => $sent['hosted_invoice_url']
        ]);

        return back()->with('success', "Invoice generated and sent!");
    }

    public function resend(Invoice $invoice){
        $stripe = new StripeClient(config('app.stripe'));
        $result = $stripe->invoices->retrieve(
            $invoice->invoice_id,
            []
        );
        if($result['paid'] == false){
            $stripe->invoices->sendInvoice($invoice->invoice_id, []);
            $invoice->increment('resends');
            $invoice->save();
            return back()->with("success", "Invoice has be Resent!");
        }else{
            return back()->with("failed", "Invoice is already paid!");
        }
    }
}
