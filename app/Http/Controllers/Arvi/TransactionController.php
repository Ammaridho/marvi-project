<?php

namespace App\Http\Controllers\Arvi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Mail\Arvi\CustomerFailOrder;
use App\Mail\Arvi\CustomerSuccessOrder;
use App\Mail\Arvi\MerchantOrderEmail;
use Illuminate\Support\Facades\Mail;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantDefinedDelivery;
use App\Models\ProductImage;
use App\Models\PredefinedDeliveryLocation;
use App\Models\ArviDelivery;
use App\Models\ArviPaymentMethod;


class TransactionController extends Controller
{
    public function storeArvi(Request $request)
    {
        
        // Store Processs merchant_orders:
        $merchant_id         = 1;
        $create_time         = Carbon::now();
        $day_deliver         = $request->datej;
        $source_ip           = $request->ip();
        $name                = $request->name;
        $email               = $request->email;
        $mobile_number       = '+65'.$request->telephone;
        $defined_delivery_id = $request->revor;
        $currency            = '$';

        // address pickup
        $address = MerchantDefinedDelivery::find($delivery_id)->name;

        // total price
        $qtot = 0;
        $pobj = json_decode($request->products);
        foreach ($pobj as $key => $value) {
            $qtot += $value->productQuan;
        }
        $qtot *= $value->productPrice;
        $total_gross_price  = $qtot;
        $merchant_payment_id = $request->pay;

        // store data order
        $merchant_orders = new MerchantOrder;
        $merchant_orders->merchant_id         = $merchant_id;
        $merchant_orders->create_time         = $create_time;
        $merchant_orders->day_deliver         = $day_deliver;
        $merchant_orders->source_ip           = $source_ip;
        $merchant_orders->name                = $name;
        $merchant_orders->email               = $email;
        $merchant_orders->mobile_number       = $mobile_number;
        $merchant_orders->delivery_id         = 1; //not null able but its pick up and not have delivery, so set it 1 
        $merchant_orders->defined_delivery_id = $defined_delivery_id;
        $merchant_orders->currency            = $currency;
        $merchant_orders->total_gross_price   = $total_gross_price;
        $merchant_orders->merchant_payment_id = $merchant_payment_id;
        $merchant_orders->save();

        //Store data detail order product
        foreach ($pobj as $key => $value) {
            $order_detail = new MerchantOrderDetail;
            $order_detail->merchant_id      = $merchant_id;
            $order_detail->create_time      = Carbon::now();
            $order_detail->product_id       = $value->productId;
            $order_detail->qty              = $value->productQuan;
            $order_detail->selling_price    = $value->productPrice;
            $order_detail->currency         = $value->productCurren;
            $order_detail->MerchantOrder()->associate($merchant_orders);  //relation associate not plural an then col name 'merchant_order' not with s
            $order_detail->save();
        }

        //payment name
        $paym = ArviPaymentMethod::find($merchant_payment_id)->name;

        //send email success to customer
        $this->customerEmailSuccess($name,$pobj,$paym,$email,$mobile_number);

        //send email to bootstrap
        $this->bootstrapEmail($address);

    }

    public function proceedToPay(Request $request)
    {

        //set hardcode payment status
        $status = 'waiting';

        if ($status == 'waiting') {
            return view('arvi.frontend.page-response-wait');
        }else if( $status == 'success'){
            return view('arvi.frontend.page-response-success');
        }else{
            return view('arvi.frontend.page-response-failed');
        }
    }

    function customerEmailSuccess($name,$pobj,$paym,$email,$mobile_number)
    {
        //send email
        $details = [
            'name'                  => $name,
            'products'              => $pobj,
            'paym'                  => $paym,
            'email'                 => $email,
            'telephone'             => $mobile_number,
        ];
        Mail::to("$email")->send(new CustomerSuccessOrder($details));
    }

    function customerEmailFail($email,$name)
    {
        //send email
        $details = [
            'name'                  => $name
        ];
        Mail::to("$email")->send(new CustomerFailOrder($details));
    }

    function bootstrapEmail($address)
    {
        //send email
        $details = [
            'address' => $address,
        ];
        Mail::to("bootstrap@gmail.com")->send(new MerchantOrderEmail($details));
    }

    
}
