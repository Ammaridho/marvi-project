<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StripePaymentChannel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // stripe channel
        $data = [
            [
                'id'                            => 13,
                'name'                          => 'Credit Card',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'fee'                           => 0,
                'currency'                      => 'SGD',
                'category'                      => 'CREDIT_CARD',
            ],
            [
                'id'                            => 14,
                'name'                          => 'Debit',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'fee'                           => 0,
                'currency'                      => 'SGD',
                'category'                      => 'DEBIT_CARD',
            ],

        ];
        DB::table('arvi_payment_methods')->insert($data);
    }
}
