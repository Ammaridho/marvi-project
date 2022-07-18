<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooProductCategoryListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('product_category_list')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'product_category_id' =>1,
                'merchant_product_id' =>4,
            ],
            [
                'product_category_id' =>1,
                'merchant_product_id' =>5,
            ],
            [
                'product_category_id' =>2,
                'merchant_product_id' =>5,
            ],
            [
                'product_category_id' =>1,
                'merchant_product_id' =>6,
            ],
        ];

        DB::table('product_category_list')->insert($data);
    }
}
