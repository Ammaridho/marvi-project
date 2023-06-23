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
        DB::table('brand_product_variants')->delete();


        $data = [
            // product 1
            [
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'panas',
                'sku'                           => 'panas123',
                'brand_product_id'              => 1,
                'retail_price'                  => 2000,
                'active'                        => 1,
            ],
            [
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'dingin',
                'sku'                           => 'dingin123',
                'brand_product_id'              => 1,
                'retail_price'                  => 3000,
                'active'                        => 1,
            ],
            
        ];

        DB::table('brand_product_variants')->insert($data);
    }
}
