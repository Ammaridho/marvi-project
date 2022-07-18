<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MerchantProductVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchant_product_variants')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'variant_type'                  => 'makanan',
                'variant_name'                  => 'sushi',
                'sku'                           => 'vr'.Str::random(5),
                'merchant_product_id'           => 1,
                'retail_price'                  => 2000,
                'currency_price'                => 'Rp',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'variant_type'                  => 'makanan',
                'variant_name'                  => 'sambal Korek',
                'sku'                           => 'vr'.Str::random(5),
                'merchant_product_id'           => 1,
                'retail_price'                  => 3000,
                'currency_price'                => 'Rp',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'variant_type'                  => 'makanan',
                'variant_name'                  => 'sambal Ijo',
                'sku'                           => 'vr'.Str::random(5),
                'merchant_product_id'           => 1,
                'retail_price'                  => 4000,
                'currency_price'                => 'Rp',
                'active'                        => 1,
            ],
            
        ];

        DB::table('merchant_product_variants')->insert($data);
    }
}
