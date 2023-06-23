<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MerchantProduct;
use App\Models\MerchantProductVariant;
use App\Models\ProductAttribute;
use App\Models\BrandExtraAttribute;
use App\Models\MerchantExtraAttribute;

class ShoppingCartController extends Controller
{
    protected $view = 'arvi.frontend.area.shopping-cart.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$code)
    {
        $shoppingCarts = [];
        $cart = $request->cart;
        if (isset($cart)) {

            foreach ($cart as $key => $value) {

                // product
                $product = MerchantProduct::
                leftJoin('product_images','merchant_products.id','=',
                    'product_images.merchant_product_id')
                ->join('merchants','merchant_products.merchant_id','=',
                    'merchants.id')
                ->where('merchant_products.id',$value['idProduct'])
                ->select(
                    'merchants.name as merchantName',
                    'merchants.id as merchantId',
                    'merchant_products.id',
                    'merchant_products.merchant_id',
                    'merchant_products.name',
                    'merchant_products.retail_price',
                    'merchant_products.currency',
                    'merchant_products.description',
                    'product_images.url',
                    'product_images.image_mime',
                    'product_images.image_type',
                    )
                ->first()->toArray();
                if (MerchantProductVariant::find($value['variant']['id'])) {
                    $variant['id']    = $value['variant']['id'];
                    $variant['name']  =
                        MerchantProductVariant::find($value['variant']['id'])->name;
                    $variant['price'] = $value['variant']['price'];
                }else{
                    $variant = null;
                }

                $qty = $value['qty'];

                if (isset($value['attribute'])) {
                    // attribute
                    foreach ($value['attribute'] as $key1 => $value1) {
                        $attribute[$key1]['id']    = $value1['id'];
                        $attribute[$key1]['name']  =
                            ProductAttribute::find($value1['id'])->name;
                        $attribute[$key1]['price'] = $value1['price'];
                        $attribute[$key1]['qty']   = $value1['qty'];
                    }
                }else{
                    $attribute = null;
                }

                // extra attribute
                if (isset($value['extraAttribute'])) {
                    foreach ($value['extraAttribute'] as $key2 => $value2) {
                        // check brand extra attribute have index 3
                        if (isset($value2['type'])) {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                                BrandExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'b';
                        } else {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                                MerchantExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'm';
                        }
                        $extraAttribute[$key2]['price']   = $value2['price'];
                        $extraAttribute[$key2]['qty']     = $value2['qty'];
                    }
                }else{
                    $extraAttribute = null;
                }

                // note
                $note = isset($value['note'])?$value['note']:'';

                $shoppingCarts[$key] = [
                    'product'               => $product,
                    'variant'               => isset($variant)?$variant:null,
                    'qty'                   => $qty,
                    'attribute'             => isset($attribute)?$attribute:null,
                    'extraAttribute'        => isset($extraAttribute)?$extraAttribute:null,
                    'note'                  => $note,
                    'totalPricePerProduct'  => $value['totalPricePerProduct'],
                    'totalPriceAll'         => $value['totalPriceAll'],
                ];
            }
        }

        // count diffrent store
        $uniqIdStore = [];
        foreach ($shoppingCarts as $key => $value) {
            if (!in_array($value['product']['merchantId'], $uniqIdStore)) {
                array_push($uniqIdStore,$value['product']['merchantId']);
            }
        }
        $countUniqStore = count($uniqIdStore);

        return view($this->view . 'index',
        compact('shoppingCarts','countUniqStore','code'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
