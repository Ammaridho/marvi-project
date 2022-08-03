<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MerchantDeliveryDropPointExport implements FromView
{
    use Exportable;

    public function __construct($noww,$displayData,$products)
    {
        $this->noww                         = $noww;
        $this->displayData                  = $displayData;
        $this->products                     = $products;
    }

    public function view(): View
    {
        return view('arvi.backend.export-view.delivery-drop-point', [
            'noww'                      => $this->noww,
            'displayData'               => $this->displayData,
            'products'                  => $this->products,
        ]);
    }
}
