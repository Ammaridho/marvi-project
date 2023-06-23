<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class XenditPaymentChannel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // xendit channel
        DB::table('arvi_payment_methods')->truncate();
        $data = [
            [
                'id'                            => 1,
                'name'                          => 'BCA',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'BCA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'VIRTUAL_ACCOUNT',
            ],
            [
                'id'                            => 2,
                'name'                          => 'BRI',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'BRI',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'VIRTUAL_ACCOUNT',
            ],
            [
                'id'                            => 3,
                'name'                          => 'BNI',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'BNI',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'VIRTUAL_ACCOUNT',
            ],
            [
                'id'                            => 4,
                'name'                          => 'Permata',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'PERMATA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'VIRTUAL_ACCOUNT',
            ],
            [
                'id'                            => 5,
                'name'                          => 'Alfamart',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'ALFAMART',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'RETAIL_OUTLET',
            ],
            [
                'id'                            => 6,
                'name'                          => 'OVO',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'OVO',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'EWALLET',
            ],
            [
                'id'                            => 7,
                'name'                          => 'DANA',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'DANA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'EWALLET',
            ],
            [
                'id'                            => 8,
                'name'                          => 'LinkAja',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'LINKAJA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'EWALLET',
            ],
            [
                'id'                            => 9,
                'name'                          => 'Visa',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'VISA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'CREDIT_CARD',
            ],
            [
                'id'                            => 10,
                'name'                          => 'Mastercard',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'MASTERCARD',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'CREDIT_CARD',
            ],
            [
                'id'                            => 11,
                'name'                          => 'JCB',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'JCB',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'CREDIT_CARD',
            ],
            [
                'id'                            => 12,
                'name'                          => 'QRIS',
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'code'                          => Str::random(5),
                'channel_code'                  => 'LINKAJA',
                'fee'                           => 0,
                'currency'                      => 'IDR',
                'category'                      => 'QR_CODE',
            ],
        ];

        DB::table('arvi_payment_methods')->insert($data);

    }
}
