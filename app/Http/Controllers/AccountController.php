<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Auth;
use Session;

class AccountController extends Controller
{
    public function create()
    {	
 		$account = Auth::user()->account;

 		if (!$account) {
 			
 			$bankList = $this->listBanks();
	    	$bankList = $bankList->data;

	    	$page = 'create_account';
	    	return view('account.create', compact('bankList', 'page', 'bankList', 'account'));
 			
 		}

 		$message = 'Account information already stored.';

		Session::flash('alert-type', 'alert-danger');
		Session::flash('message', $message);
			
		return redirect()->route('home');

    	
    }

    public function store(Request $request)
    {

    	$this->validate($request, [
    		'account_name' => 'required|string',
    		'account_number' => 'required|numeric|digits:10',
    		'bank_code' => 'required|string',
    		'bvn' => 'required|numeric|digits:11',
    	]);

    	// check if account number is valid and is for that bank
    	$response = $this->resolveAccountNumber($request->account_number, $request->bank_code);
    	if ($response->status === true) {

    		$bankList = $this->listBanks();
	    	$bankList = $bankList->data;

	    	$bank = collect($bankList);
	    	$bankName = $bank->where('code', $request->bank_code)->pluck('name');


    		Account::create([
	    		'user_id' => Auth::id(),
	    		'account_name' => $response->data->account_name,
	    		'account_number' => $response->data->account_number,
	    		'account_bank' => $bankName[0],
	    		'bank_code' => $request->bank_code,
	    		'bvn' => $request->bvn,	
	    	]);

    	}else{
    		return redirect()->back()->withErrors(['Incorrect account details, please check that account number matches the bank.']);
    	}

    	$message = 'Account information updated successfully.';

    	$request->session()->flash('message', $message);
    	$request->session()->flash('alert-type', 'alert-success');

    	return redirect()->route('home');
    		
    }

    public function transactions()
    {
    	$account = Auth::user()->account;
    	$transactions = \App\CurrencyChange::where(['user_id' => Auth::id(), 'status' => 1])->get();
    	return view('account.transactions', compact('transactions', 'account'));
    }

    public function resolveAccountNumber($account_number, $bank_code)
    {
	 	$curl = curl_init();
  
	  	curl_setopt_array($curl, array(
		    CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$account_number."&bank_code=".$bank_code,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 30,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "GET",
		    CURLOPT_HTTPHEADER => array(
		      "Authorization: Bearer sk_test_a0456e90666e29d222de159158215ccc0d8a8e89",
		      "Cache-Control: no-cache",
		    ),
	  	));
		  
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
    }

    public function listBanks()
    {
		$curl = curl_init();
  
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/bank?country=nigeria",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "Authorization: Bearer sk_test_a0456e90666e29d222de159158215ccc0d8a8e89",
			  "Cache-Control: no-cache",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}

    }

    public function createTransferRecipient($account_number, $bank_code)
    {
    	$url = "https://api.paystack.co/transferrecipient";
		
		$fields = [
			"type" => "nuban",
			"name" => "Bureau De Change service.",
			"description" => "Paulina Bureau De Change service",
			"account_number" => $account_number,
			"bank_code" => $bank_code,
			"currency" => "NGN"
		];
		
		$fields_string = http_build_query($fields);
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer sk_test_a0456e90666e29d222de159158215ccc0d8a8e89",
			"Cache-Control: no-cache",
		));

		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

		//execute post
		$result = curl_exec($ch);
		return json_decode($result);
	}

	public function initiateTransfer($amount, $recipient_code)
	{
		$url = "https://api.paystack.co/transfer";
		$fields = [
			"source" => "balance", 
			"reason" => "Bereau De Change", 
			"amount" => $amount, 
			"recipient" => $recipient_code
		];
		
		$fields_string = http_build_query($fields);
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer sk_test_a0456e90666e29d222de159158215ccc0d8a8e89",
			"Cache-Control: no-cache",
		));

		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

		//execute post
		$result = curl_exec($ch);
		return json_decode($result);
	}
}
