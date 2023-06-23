<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MerchantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'create_time'           => Carbon::today()->addDays(rand(1, 365)),
                'code'                  => 'mrc'. Str::random(10),
                'name'                  => 'Baso Tak Terduga',
                'loc_aware'             => 1,
                'loc_lon'               => 0,
                'loc_lat'               => 0,
                'description'           => 'ini adalah deskripsi Merchant',
                'address'               => $faker->address,
                'city'                  => $faker->city,
                'country'               => $faker->country,
                'postal_code'           => $faker->postcode,
                'location_label'        => $faker->streetSuffix,
                'loc_aware_tolerance'   => 0,
                'loc_aware_uom'         => 0,
                'company_id'            => 1,
                'order_days_ahead'      => $faker->numberBetween(0,7),
                'active'                => 0, 
            ],
            [
                'create_time'           => Carbon::today()->addDays(rand(1, 365)),
                'code'                  => 'mrc'. Str::random(10),
                'name'                  => 'Mie Ayam Donoloyo',
                'loc_aware'             => 1,
                'loc_lon'               => 0,
                'loc_lat'               => 0,
                'description'           => 'ini adalah deskripsi Merchant',
                'address'               => $faker->address,
                'city'                  => $faker->city,
                'country'               => $faker->country,
                'postal_code'           => $faker->postcode,
                'location_label'        => $faker->streetSuffix,
                'loc_aware_tolerance'   => 0,
                'loc_aware_uom'         => 0,
                'company_id'            => 1,
                'order_days_ahead'      => $faker->numberBetween(0,7),
                'active'                => 0, 
            ],
        ];

        DB::table('merchants')->insert($data);
    }
}
