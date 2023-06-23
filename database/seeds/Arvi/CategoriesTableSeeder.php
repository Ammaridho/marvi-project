<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
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
                'category_name'     => 'Food',
                'category_type'     => 'fixed',
                'avaibility_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
            [
                'category_name' => 'Drinks',
                'category_type' => 'fixed',
                'avaibility_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
            [
                'category_name' => 'Dessert',
                'category_type' => 'fixed',
                'avaibility_store'  => '["1","2"]',
                'deliver_method'    => '["1","2"]' 
            ],
        ];

        DB::table('product_categories')->insert($data);
    }
}
