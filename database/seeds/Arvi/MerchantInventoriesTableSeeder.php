<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MerchantInventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchant_inventories')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 1,
                'merchant_product_variant_id'   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 1,
                'merchant_product_variant_id'   => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
            // product 2
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 2,
                'merchant_product_variant_id'   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 2,
                'merchant_product_variant_id'   => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
            // product 3
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 3,
                'merchant_product_variant_id'   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
            [
                'merchant_id'                   => 1,
                'merchant_product_id'           => 3,
                'merchant_product_variant_id'   => 2,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'total_available'               => 7,
                'total_allocate'                => 4,
                'total_reserved'                => 3,
            ],
        ];

        DB::table('merchant_inventories')->insert($data);
    }
}
