<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promo\Promotion;
use App\Models\Promo\PromotionCode;
use App\Models\Promo\MerchantOrderPromotion;
use App\Models\User;
use App\Models\MerchantOrder;
use App\Models\Merchant;

class PromoController extends Controller
{
    public function check(Request $request)
    {
        $code       = $request->code;
        $storeCode  = $request->storeCode;
        $email      = $request->email;

        // check, promo have been used 
        // 1 = not used
        // 0 = used
        
        // get user id
        $user = User::where('email',$email)->first();
        if (isset($user)) {
            $id = $user->id;
        }else{
            return response()->json(['message'=>'email not found', 'status'=>404]);
        }

        // check validation code
        $promoCode = PromotionCode::where('code',$code)->first();
        if ($promoCode) {

            // merchant id
            $merchant = Merchant::where('code',$storeCode)->first(); 
            if (isset($merchant)) {
                $merchantId = $merchant->id;
            }else{
                return response()->json(['message'=>'store not found', 'status'=>404]);
            }

            // get all order based account order
            $orderId = MerchantOrder::where('merchant_id',$merchantId)
            ->where('user_id',$id)->pluck('id');
            foreach ($orderId as $key => $value) {

                // cek order use promo code
                $promoHaveBeenUsed = MerchantOrderPromotion::
                where('merchant_order_id',$value)
                ->where('code',$code)->first();
                if ($promoHaveBeenUsed) {
                    return response()->json(['valid' => 0]);
                }

            }
            return response()->json(['valid' => 1]);

        }
        return response()->json(['message' => 'code not found','status'=>404]);
    }
}
