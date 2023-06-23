<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MerchantDeliveryDropPointExport implements FromView
{
    use Exportable;

    public function __construct($noww,$data,$products)
    {
        $this->noww                         = $noww;
        $this->data                         = $data;
        $this->products                     = $products;
    }

    public function view(): View
    {
        return view('arvi.backend.export-view.delivery-drop-point', [
            'noww'                      => $this->noww,
            'data'                      => $this->data,
            'products'                  => $this->products,
        ]);
    }
}
