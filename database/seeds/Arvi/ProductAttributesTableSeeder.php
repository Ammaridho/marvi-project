<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brand_product_attributes')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'brand_product_id'              => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'gula',
                'retail_price'                  => 2000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'creamer',
                'retail_price'                  => 3000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'susu',
                'retail_price'                  => 1000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'gula',
                'retail_price'                  => 1000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'creamer',
                'retail_price'                  => 2000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 3,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'gula',
                'retail_price'                  => 3000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ],
            [
                'brand_product_id'              => 3,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'chocolate syrup',
                'retail_price'                  => 2000,
                'currency'                      => 'IDR',
                'active'                        => 1,
            ]
            
        ];

        DB::table('brand_product_attributes')->insert($data);
    }
    
}
