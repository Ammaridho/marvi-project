<?php

namespace App\Http\Controllers\Sushimoo\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// db
use App\Models\MerchantProduct;
use App\Models\ExtraAttribute;

class CartController extends Controller
{
    protected $route = 'cart.';
    protected $view = 'sushimoo.frontend.';

    public function index(Request $request)
    {
        $view = $this->view;

        $cart = session()->get('cart');

        $i = 0;
        $a = 0;

        do {

            if(isset($cart[$i])){                                              //jika ditemukan //012

                $cart[$i]['product'] = MerchantProduct::find($cart[$i]['idProduct']);              //ambil produk berdasarkan id
                
                $ecn = $cart[$i]['extraCon'];
                foreach ($ecn as $key => $value) {
                    $cart[$i]['extraConData'][$key] = ExtraAttribute::find($key);
                }

                $ect = $cart[$i]['extraCut'];
                foreach ($ect as $key => $value) {
                    $cart[$i]['extraCutData'][$key] = ExtraAttribute::find($key);
                }

                $a+=1;                                                  //increment nilai a
            }

            $i++;

        } while ($a < count($cart));

        $aa = $cart;

        return view($view.'page-cart',compact('cart','aa'));
    }

    public function store(Request $request)
    {
        $idProduct    = $request->idProduct;
        $qp           = $request->qtyProduct;
        $extraCon     = $request->extraCon;
        $extraCut     = $request->extraCut;
        $notesProduct = $request->notesProduct;

        // session()->flush(); //delete session

        $cart = session()->get('cart');

        $a = true;
        $i = 0;

        do{
            if (!isset($cart[$i])) {
                //cek array extraCondiments not 0
                foreach ($extraCon as $key => $value) {
                    if($value == 0){
                        unset($extraCon[$key]);
                    }
                }
                //cek array extraCutlery not 0
                foreach ($extraCut as $key => $value) {
                    if($value == 0){
                        unset($extraCut[$key]);
                    }
                }

                // totalPrice
                    // product
                    // $pp = parseInt(MerchantProduct::find($idProduct)->retail_price);
                    // quantity
                    // $qp
                    // extracon
                    // $extraCon
                    
                    // extracut


                $tp = 0;

                // insert array
                $cart[$i] = [
                    "idProduct" => $idProduct,
                    "quantity"  => $qp,
                    "totalPrice"=> $tp,
                    "extraCon"  => $extraCon,
                    "extraCut"  => $extraCut,
                    "remarks"   => $notesProduct,
                ];
                $a = false;
            }
            $i++;
        }while($a);

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');

    }

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function destroy(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
