<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Currency;
use App\CurrencyChange;

class CurrencyChangeController extends Controller
{
    public function initiate()
    {
    	$currencies = Currency::all();
        $user = Auth::user();
        $account = $user->account;
    	return view('currency-change.initiate', compact('currencies', 'account'));
    }

    public function confirmChange(Request $request)
    {

        $user = Auth::user();
        $account = $user->account;

    	$this->validate($request, [
    		'from_currency' => 'required',
    		'to_currency' => 'required',
    	]);

    	// NGN naira is the base currency, all currencies are to be converted to Naira.
    	// Using naira since I am using the paystack payment gateway which only supports Naira.
    	$base_currency = Currency::where('base', true)->first();
    	
    	// this value should come from database
    	$charge = 200;

    	$from_currency = Currency::find($request->from_currency);
		$from_currency_rate = $from_currency->rate;

		$to_currency = Currency::find($request->to_currency);
		$to_currency_rate = $to_currency->rate;

    	// Convert payment to naira.
    	if ($from_currency->id == $base_currency->id) {
    		
    		
    		$deposit_naira = $request->amount / $from_currency->rate;
            $deposit_naira = $deposit_naira * $base_currency->rate;
            // dd($deposit_naira);

    		
    	}else{

    		$deposit_naira = $request->amount * $base_currency->rate;

    	}

    	
    	// Save transaction
    	$orderTrnx = CurrencyChange::create([
    		'user_id' => Auth::id(),
    		'from_currency' => $request->from_currency,
    		'to_currency' => $request->to_currency,
    		'base_currency' => $base_currency->id,
    		'amount' => $request->amount,
    		'converted_amount' => $deposit_naira,
    	]);

    	if ($orderTrnx) {
    		
    		return view('currency-change.confirm', compact('orderTrnx', 'charge', 'account'));
    	}
    	else{
    		dd('errors');
    	}

    	
    
    }
}
