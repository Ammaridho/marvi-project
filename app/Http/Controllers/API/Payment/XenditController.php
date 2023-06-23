<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;

use Xendit\Xendit;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;
use \stdClass;

use App\Models\MerchantOrder;

class XenditController extends Controller
{
    protected $token,$callback_token;

    public function __construct()
    {   
        $this->token = config('services.xendit.token');
        $this->callback_token = config('services.xendit.callback_token');
    }

    // list payment methods
    public function getListChannel()
    {
        $client = new Client();
        $headers = [
            'Authorization' => $this->token,
        ];
        $request = new Request('GET', 'https://api.xendit.co/v2/payment_methods', 
        $headers);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);
    }

    // virtual account
    public function createVa($external_id,$channel_code,$name,$amount)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->token
        ];

        $body = new stdClass();
        $body->external_id      =  $external_id.'-'.Str::random(10);
        $body->bank_code        = $channel_code;
        $body->name             = $name;
        $body->is_closed        = true;
        $body->expected_amount  = $amount;
        $body->expiration_date  = Carbon::now()->addDay(1)->toISOString();

        $request = new Request('POST', 'https://api.xendit.co/callback_virtual_accounts', 
        $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);
    }

    // e-wallet
    public function createEw($external_id,$channel_code,$name,$amount,$linkSuccess,$linkFailed)
    {
        // postman
        $client = new Client();
        $headers = [
        'Authorization' => $this->token,
        'Content-Type' => 'application/json',
        ];

        $body = new stdClass();
        $body->reference_id       =  $external_id.'-'.Str::random(10);
        $body->currency           = "IDR";
        $body->amount             = $amount;
        $body->checkout_method    = "ONE_TIME_PAYMENT";
        $body->channel_code       = 'ID_'.$channel_code;
        $body->channel_properties = [
            "success_redirect_url" => $linkSuccess,
            "failure_redirect_url" => $linkFailed,
        ];

        $request = new Request('POST', 'https://api.xendit.co/ewallets/charges', 
        $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);

    }
    public function createEwOvo($external_id,$channel_code,$name,$amount,$noTelpOvo)
    {
        // postman
        $client = new Client();
        $headers = [
        'Authorization' => $this->token,
        'Content-Type' => 'application/json',
        ];

        $body = new stdClass();
        $body->reference_id       =  $external_id.'-'.Str::random(10);
        $body->currency           = "IDR";
        $body->amount             = $amount;
        $body->checkout_method    = "ONE_TIME_PAYMENT";
        $body->channel_code       = 'ID_'.$channel_code;
        $body->channel_properties = [
            "mobile_number" => $noTelpOvo
        ];

        $request = new Request('POST', 'https://api.xendit.co/ewallets/charges',
        $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);

    }

    // qris
    public function createQr($external_id,$channel_code,$name,$amount)
    {
        $client = new Client();
        $headers = [
            'api-version' => '2022-07-31',
            'Authorization' => $this->token,
            'Content-Type' => 'application/json'
        ];

        $body = new stdClass();
        $body->reference_id =  $external_id.'-'.Str::random(10);
        $body->type         = "DYNAMIC";
        $body->currency     = "IDR";
        $body->amount       = $amount;
        $body->expires_at   = Carbon::now()->addMinutes(2)->toISOString();

        $request = new Request('POST', 'https://api.xendit.co/qr_codes', 
        $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);
    }

    // retail outlet
    public function createRo($external_id,$channel_code,$name,$amount)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->token
        ];

        $body = new stdClass();
        $body->external_id        = $external_id.'-'.Str::random(10);
        $body->retail_outlet_name = $channel_code;
        $body->name               = $name;
        $body->expected_amount    = $amount;
        
        $request = new Request('POST', 'https://api.xendit.co/fixed_payment_code',
         $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody(),true);
    }

    // CALLBACK =================
    public function callbackEw()
    {
        // token callback env
        $xenditXCallbackToken = $this->callback_token;

        // token callback xendit
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ?
        $reqHeaders['X-Callback-Token'] : "";

        // validation token
        if($xIncomingCallbackTokenHeader === $xenditXCallbackToken){
            $rawRequestInput =  request()->all();
            
            $_id                 = $rawRequestInput['data']['id'];
            $_status             = $rawRequestInput['data']['status'];
            $_paidAmount         = $rawRequestInput['data']['capture_amount'];

            // check data
            if ($order = MerchantOrder::where('payment_id',$_id)->first()) {
                $order->payment_status = 1;
                $order->save();
    
                return 'success';
            }
            return 'no data with payment_id : ' . $_id;
            
        }else{
            return 'error';
            // Request is not from xendit, reject and throw http status forbidden
            return http_response_code(403);
        }
    }

    public function callbackQr()
    {
        // token callback env
        $xenditXCallbackToken = $this->callback_token;

        // token callback xendit
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders["X-Callback-Token"]) ?
        $reqHeaders["X-Callback-Token"] : "";

        // validation token
        if($xIncomingCallbackTokenHeader === $xenditXCallbackToken){
            $rawRequestInput =  request()->all();
            
            $_id                 = $rawRequestInput['data']['qr_id'];
            $_status             = $rawRequestInput['data']['status'];
            $_paidAmount         = $rawRequestInput['data']['amount'];

            // check data
            if ($order = MerchantOrder::where('payment_id',$_id)->first()) {
                $order->payment_status = 1;
                $order->save();
    
                return 'success';
            }
            return 'no data with payment_id : ' . $_id;
        }else{
            return 'error';
            // Request is not from xendit, reject and throw http status forbidden
            return http_response_code(403);
        }
    }

    public function callbackVa()
    {
        // token callback env
        $xenditXCallbackToken = $this->callback_token;

        // token callback xendit
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders["X-Callback-Token"]) ?
         $reqHeaders["X-Callback-Token"] : "";

        // validation token
        if($xIncomingCallbackTokenHeader === $xenditXCallbackToken){
            $rawRequestInput =  request()->all();
            
            $_id                 = $rawRequestInput['id'];
            $_paidAmount         = $rawRequestInput['amount'];

            // check data
            if ($order = MerchantOrder::where('payment_id',$_id)->first()) {
                $order->payment_status = 1;
                $order->save();
    
                return 'success';
            }
            return 'no data with payment_id : ' . $_id;
            
        }else{
            // Request is not from xendit, reject and throw http status forbidden
            return http_response_code(403);
        }
    }

    public function callbackRo()
    {
        // token callback env
        $xenditXCallbackToken = $this->callback_token;

        // token callback xendit
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders["X-Callback-Token"]) ?
         $reqHeaders["X-Callback-Token"] : "";

        // validation token
        if($xIncomingCallbackTokenHeader === $xenditXCallbackToken){
            $rawRequestInput =  request()->all();
            
            $_id                 = $rawRequestInput['id'];
            $_paidAmount         = $rawRequestInput['amount'];

            $order = MerchantOrder::where('payment_id',$_id)->first();
            $order->payment_status = 1;
            $order->save();
            
        }else{
            // Request is not from xendit, reject and throw http status forbidden
            return http_response_code(403);
        }
    }
}
