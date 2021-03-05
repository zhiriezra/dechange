<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\AccountController;
use App\CurrencyChange;

use Paystack;
use Auth;
use Session;

class PaymentController extends Controller
{   

    protected $AccountController;

    public function __construct(AccountController $AccountController)
    {
        $this->AccountController = $AccountController;
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();


        if ($paymentDetails['message'] === 'Verification successful') {


            $paymentData =  $paymentDetails['data'];
            $transaction_id = $paymentData['metadata']['transaction_id'];

            $paymentInfo = CurrencyChange::find($transaction_id);
            
            $paymentInfo->status = 1;
            $paymentInfo->refrence = $paymentData['reference'];
            $paymentInfo->save();

            $account_number = Auth::user()->account->account_number;
            $bank_code = Auth::user()->account->bank_code;

            $response = $this->AccountController->resolveAccountNumber($account_number, $bank_code);

            if ($response->status === true) {

                $createTransfer = $this->AccountController->createTransferRecipient($account_number, $bank_code);

                $recipient_code = $createTransfer->data->recipient_code;
                $amount = $paymentData['amount'];

                if ($createTransfer->message === 'Transfer recipient created successfully') {

                    $transfer = $this->AccountController->initiateTransfer($amount, $recipient_code);

                    // can't initate transfer on demo
                    $message = 'Payment was successful, but we cannot initiate transfer to a bank account on paystack demo';
                    Session::flash('message', $message);
                    Session::flash('alert-type', 'alert-info');
                    return redirect()->route('home');
                }
            }

            
        }
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}