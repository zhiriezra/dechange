<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\CurrencyChange;

class AdminController extends Controller
{
    public function transactions($value='')
    {
    	$transactions = CurrencyChange::where('status', 1)->get();
    	return view('admin.transactions', compact('transactions'));
    }
}
