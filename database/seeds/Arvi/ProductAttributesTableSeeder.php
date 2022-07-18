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
        DB::table('product_attributes')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_product_id'           => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'sambal Matah',
                'fee'                           => 0.5,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'sambal Korek',
                'fee'                           => 0.8,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'sambal Ijo',
                'fee'                           => 0.2,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'Mayonais',
                'fee'                           => 0.2,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'cheese sauce',
                'fee'                           => 0.5,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 3,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'Ice Cream Vanila',
                'fee'                           => 0.7,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_product_id'           => 3,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'chocolate syrup',
                'fee'                           => 0.6,
                'currency'                      => '$',
                'active'                        => 1,
            ]
            
        ];

        DB::table('product_attributes')->insert($data);
    }
    
}
