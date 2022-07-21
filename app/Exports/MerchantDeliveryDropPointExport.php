<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MerchantDeliveryDropPointExport implements FromView
{
    use Exportable;

    public function __construct($noww,$joinForDeliveryDropPoints,$deliveryDropPointNew,
        $products)
    {
        $this->noww                         = $noww;
        $this->joinForDeliveryDropPoints    = $joinForDeliveryDropPoints;
        $this->deliveryDropPointNew         = $deliveryDropPointNew;
        $this->products                     = $products;
    }

    public function view(): View
    {
        return view('arvi.backend.export-view.delivery-drop-point', [
            'noww'                      => $this->noww,
            'joinForDeliveryDropPoints' => $this->joinForDeliveryDropPoints,
            'deliveryDropPointNew'      => $this->deliveryDropPointNew,
            'products'                  => $this->products,
        ]);
    }
}
