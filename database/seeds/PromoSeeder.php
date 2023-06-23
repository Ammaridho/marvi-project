<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code = 'code-test';
        $order = DB::table('merchant_orders')->orderBy('id','desc')
        ->whereNotNull('user_id')->first();

        $mop = [
            [
                'promotion_code_id'     => 1,
                'code'                  => $code,
                'merchant_order_id'     => $order->id,
                'create_time'           => Carbon::now(),
            ],
        ];
        DB::table('merchant_order_promotion')->insert($mop);

        $pc = [
            [
                'promotion_id'          => 1,
                'code'                  => $code,
                'is_active'             => 1,
                'create_time'           => Carbon::now(),
            ],
        ];

        DB::table('promotion_codes')->insert($pc);

        $p = [
            [
                'company_id'            => DB::table('brands')->find($order->brand_id)->company_id,
                'brand_id'              => $order->brand_id,
                'type_code'             => 0,
                'date_start'            => \Carbon\Carbon::now(),
                'date_end'              => \Carbon\Carbon::now()->addDays(5),
                'promo_type'            => 0,
                'promo_value'           => 10000,
                'validation_type'       => 0,
                'create_time'           => Carbon::now(),
            ],
        ];

        DB::table('promotions')->insert($p);
    }
}
