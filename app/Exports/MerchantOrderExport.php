<?php

namespace App\Exports;

use App\Models\MerchantOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class MerchantOrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MerchantOrder::all();
    }
}
