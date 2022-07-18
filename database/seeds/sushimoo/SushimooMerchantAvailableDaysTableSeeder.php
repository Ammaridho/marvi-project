<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooMerchantAvailableDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('merchant_available_days')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 4,   //4 = sushimoo
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'day_of_week'                   => 3,
                'hours_csv'                     => 4,
            ],
        ];

        DB::table('merchant_available_days')->insert($data);
    }
}
