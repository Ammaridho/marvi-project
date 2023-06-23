<?php

use Illuminate\Database\Seeder;

class FlavarPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code = 'mrc5rvi4WOU9h';
        $data = [
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','Credit Card')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Stripe')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'SGD',
            ],
        ];

        DB::table('merchant_payments')->insert($data);
    }
}
