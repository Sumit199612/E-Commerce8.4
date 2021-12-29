<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PaytmWallet;
use App\Models\Paytm;
use App\Models\User;
use DB;

class PaytmController extends Controller
{
    
    // display a form for payment
    public function initiate()
    {
        return view('orders.thanks');
    }

    public function pay(Request $request)
    {
            $amount = 152.99; //Amount to be paid

            $userData = [
                'name' => "Keshri Manish", // Name of user
                'mobile' => 7016648610, //Mobile number of user
                'email' => "keshrisumit441.sk@gmail.com", //Email of user
                'fee' => $amount,
                'order_id' => $request->mobile."_".rand(1,1000) //Order id
            ];

            // $userData = [
            //     'name' => $request->name, // Name of user
            //     'mobile' => $request->mobile, //Mobile number of user
            //     'email' => $request->email, //Email of user
            //     'fee' => $amount,
            //     'order_id' => $request->mobile."_".rand(1,1000) //Order id
            // ];

            $paytmuser = Paytm::create($userData); // creates a new database record

            $payment = PaytmWallet::with('receive');

            $payment->prepare([
                'order' => $userData['order_id'], 
                'user' => $paytmuser->id,
                'mobile_number' => $userData['mobile'],
                'email' => $userData['email'], // your user email address
                'amount' => $userData['fee'], // amount will be paid in INR.
                'callback_url' => route('status') // callback URL
            ]);
            // $payment->prepare([
            //     'order' => 25, 
            //     'user' => 'cust_id_12',
            //     'mobile_number' => 7016648610,
            //     'email' => 'keshrisumit441@gmail.com', // your user email address
            //     'amount' => 3000, // amount will be paid in INR.
            //     'callback_url' => 'http://localhost/paytm/public/payment/status' // callback URL
            // ]);
            return $payment->receive();  // initiate a new payment
    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        // dd($response);
        
        $order_id = $transaction->getOrderId(); // return a order id
      
        $transaction->getTransactionId(); // return a transaction id
    
        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is successfull.");

        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is failed.");
            
        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        
        // $transaction->getOrderId(); // Get order id
    }
}

