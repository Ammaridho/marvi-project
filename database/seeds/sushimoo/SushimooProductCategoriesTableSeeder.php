<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'merchant_id'   => 4,
                'category_name' => 'Personal Platter',
                'category_type' => 'regullar',
                'is_promo'      => 0,
            ],
            [
                'merchant_id'   => 4,
                'category_name' => 'Medium Platter',
                'category_type' => 'regullar',
                'is_promo'      => 0,
            ],
            [
                'merchant_id'   => 4,
                'category_name' => 'Promotion Lebaran',
                'category_type' => 'Promo',
                'is_promo'      => 1,
                // 'discount'      => 0,
            ],
        ];

        DB::table('product_categories')->insert($data);
    }
}
