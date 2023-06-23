<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class BrandCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'brand_id'          => 1,
                'category_name'     => 'Food',
                'category_type'     => 'fixed',
                'create_time'       => Carbon::now(),
                'availability_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
            [
                'brand_id'          => 1,
                'category_name' => 'Drinks',
                'category_type' => 'fixed',
                'create_time'       => Carbon::now(),
                'availability_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
            [
                'brand_id'          => 1,
                'category_name' => 'Dessert',
                'category_type' => 'fixed',
                'create_time'       => Carbon::now(),
                'availability_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
        ];

        DB::table('brand_categories')->insert($data);
    }
}
