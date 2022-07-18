<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ArviPaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('arvi_payment_methods')->delete();
        $data = [
            // product 1
            [
                'id'                            => 1,
                'name'                          => 'Credit Card',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => 'CC',
                'fee'                           => 0,
                'currency'                      => 'IDR',
            ],
            [
                'id'                            => 2,
                'name'                          => 'Debit',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => 'DEBIT',
                'fee'                           => 0,
                'currency'                      => 'IDR',
            ],
            [
                'id'                            => 3,
                'name'                          => 'Bank Transfer',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => 'TRANSFER',
                'fee'                           => 0,
                'currency'                      => 'IDR',
            ],


            [
                'id'                            => 21,
                'name'                          => 'GoPay',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => 'GOPAY',
                'fee'                           => 0,
                'currency'                      => 'IDR',
            ],
            [
                'id'                            => 22,
                'name'                          => 'OVO',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => 'OVO',
                'fee'                           => 0,
                'currency'                      => 'IDR',
            ]

        ];

        DB::table('arvi_payment_methods')->insert($data);
    }
}
