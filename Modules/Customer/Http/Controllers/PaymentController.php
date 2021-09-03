<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Customer\Entities\User;
use Modules\Customer\Entities\Order_payment;
use Modules\Customer\Entities\Payment_gateway;
use Modules\Customer\Entities\Exchange_rate;
use Illuminate\Support\Facades\Validator;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use Auth;
use Session;

class PaymentController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $_api_context;

    public function __construct() {

//        $this->middleware('auth');
        // setup PayPal api context
        $paypal_conf = config('paypal');
        
        $this->_api_context = new ApiContext(new OAuthTokenCredential
                ($paypal_conf['client_id'], $paypal_conf['secret']));
        
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
    }

    public function pay_by_paypal(Request $request) {

        $itemName = "Sale";
        $totalcost = $request->total_amount;
        $order_id = $request->order_id;
        
        $converted = $this->convertcurrency($totalcost);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('shop/payments/paypal_payments/' . $order_id))
                ->setCancelUrl(url('shop/transaction/cancel/' . $order_id));

        $intent = 'Sale';
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($itemName)// item name
//       ->setCurrency($order->currency->name)
                ->setCurrency("USD")
                ->setQuantity(1)
                ->setPrice($converted);

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency("USD")
                ->setTotal($converted);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription($itemName);

        $payment = new Payment();
        $payment->setIntent($intent)
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Session::flash('flash_message', 'Something Went wrong, funds could not be loaded');
            Session::flash('alert-class', 'danger no-auto-close');
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            // redirect to paypal
            return redirect($redirect_url);
        }

        Session::flash('alert', 'Unknown error occurred');
        Session::flash('alertClass', 'danger no-auto-close');
        return redirect(url()->previous());
    }

    // Paypal process payment after it is done
    public function getPaymentStatus($order_id, Request $request) {

        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::flash('flash_message', 'Payment failed');
            Session::flash('alertClass', 'danger no-auto-close');
            return redirect('load');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // payment made
            // Payment is successful do your business logic here

            $todaysDate = date('Y-m-d H:i:s');
            $order = Order::findorfail($order_id);
            $gateway = Payment_gateway::where('name', "PAYPAL")->first()->id;
            
            $order->payment_status = "PAID";
            $order->save();
            
            $orderPayment = new Order_payment();

            $orderPayment->order_id = $order_id;
            $orderPayment->user_id = $order->user_id;
            $orderPayment->payment_gateway_id = $gateway;
            $orderPayment->amount = $order->total_value;
            $orderPayment->status = "PAID";
            $orderPayment->transaction_date = $todaysDate;

            $orderPayment->save();

            Session::flash('flash_message', 'Your  order  was paid  for '
                    . 'successfully. Thank you.');

            return redirect(url('shop/transaction/success/' . $order_id));
        }

        Session::flash('alert', 'Unexpected error occurred & payment has failed.');
        Session::flash('alert-class', 'alert-danger');
        return redirect(url()->previous());
    }


    public function convertcurrency($amount) {

        $basecurrency = "KES";
        $preferredcurrency = "USD";

        $todaysDate = date('Y-m-d');

        $exchange_rate = Exchange_rate::where('applicable_date', $todaysDate)
                        ->where('base_currency', $basecurrency)
                        ->where('converted_currency', $preferredcurrency)
                        ->orderBy('id', 'DESC')->first();

        if ($exchange_rate == null) {

            $exchange_rate = Exchange_rate::where('base_currency', $basecurrency)
                            ->where('converted_currency', $preferredcurrency)
                            ->orderBy('applicable_date', 'DESC')->first();
        }

        $rate = $exchange_rate->rate;

        $convertedamount = ceil($amount * $rate);

        return $convertedamount;
    }

}