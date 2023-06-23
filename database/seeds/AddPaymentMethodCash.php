<?php

use Illuminate\Database\Seeder;

class AddPaymentMethodCash extends Seeder
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
                'id'                            => 0,
                'name'                          => 'CASH',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'CASH',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'CASH',
            ],
        ];

        DB::table('arvi_payment_methods')->insert($data);

        $data = [
            [
                'merchant_id'           => DB::table('merchants')->where('code','mrcDVRw9UUdYq')->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','CASH')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Cashier')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code','mrc5rvi4WOU9h')->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','CASH')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Cashier')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
        ];

        DB::table('merchant_payments')->insert($data);
    }
}
