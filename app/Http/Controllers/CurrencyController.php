<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){
        return view('currencies', [
            'currencies' => Currency::latest()->paginate(20)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|max:3',
        ]);
        Currency::create([
            'name' => $request->name,
            'code' => strtolower($request->code)
        ]);
        return back()->with('success', 'Currency has been created!');
    }
}
