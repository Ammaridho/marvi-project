<?php

namespace App\Exports;

use App\Models\MerchantOrder;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MerchantOrderExport implements FromView
{
    use Exportable;

    public function __construct($noww,$joinForOrderDetails,$countProduct,$productsOrder,$products)
    {
        $this->noww                 = $noww;
        $this->joinForOrderDetails  = $joinForOrderDetails;
        $this->countProduct         = $countProduct;
        $this->productsOrder        = $productsOrder;
        $this->products             = $products;
    }

    public function view(): View
    {
        return view('arvi.backend.export-view.order-list', [
            'noww'                  => $this->noww,
            'joinForOrderDetails'   => $this->joinForOrderDetails,
            'countProduct'          => $this->countProduct,
            'productsOrder'         => $this->productsOrder,
            'products'              => $this->products,
        ]);
    }

}
