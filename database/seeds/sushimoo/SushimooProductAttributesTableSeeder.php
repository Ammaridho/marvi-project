<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('product_attributes')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            // [
            //     'merchant_product_id'           => 3,
            //     'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
            //     'name'                          => 'chocolate syrup',
            //     'fee'                           => 2000,
            //     'currency'                      => 'Rp',
            //     'active'                        => 1,
            // ]
            
        ];

        DB::table('product_attributes')->insert($data);
    }
    
}
