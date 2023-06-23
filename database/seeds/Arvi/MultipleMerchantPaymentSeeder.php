<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class MultipleMerchantPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'payment_method_id'     => 1,
                'payment_provider_id'   => 1,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
                'create_time'           => Carbon::today()->subDays(rand(0, 365)),
            ],
            [
                'payment_method_id'     => 2,
                'payment_provider_id'   => 1,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
                'create_time'           => Carbon::today()->subDays(rand(0, 365)),
            ],
        ];

        DB::table('multiple_merchant_payments')->insert($data);
    }
}
