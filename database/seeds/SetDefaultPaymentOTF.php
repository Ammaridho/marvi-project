<?php

use Illuminate\Database\Seeder;

/**
 * THIS SHOULD BE RUN ONCE!
 */
class SetDefaultPaymentOTF extends Seeder
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
                'merchant_id'           => 1,
                'payment_method_id'     => 1,
                'payment_provider_id'   => 1,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'SGD',
            ],
            [
                'merchant_id'           => 1,
                'payment_method_id'     => 2,
                'payment_provider_id'   => 1,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'SGD',
            ],
        ];

        DB::table('merchant_payments')->insert($data);
    }
}
