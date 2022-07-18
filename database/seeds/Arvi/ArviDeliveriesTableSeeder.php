<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ArviDeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('arvi_deliveries')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'name'        => 'Pick Up',
                'code'        => 'dlv'. Str::random(5),
                'external'    => 1,
                'create_time' => Carbon::create('2022', '10', '01'),
                'cost_delivery' => 0,
                'currency'      => '$',
            ],
            [
                'name'        => 'Delivery',
                'code'        => 'dlv'. Str::random(5),
                'external'    => 1,
                'create_time' => Carbon::create('2022', '10', '01'),
                'cost_delivery' => 1,
                'currency'      => '$',
            ],
            // [
            //     'name'        => 'Paksel',
            //     'code'        => 'dlv'. Str::random(5),
            //     'external'    => 1,
            //     'create_time' => Carbon::create('2022', '10', '01'),
            //     'cost_delivery' => 9,
            //     'currency'      => '$',
            // ],
            // [
            //     'name'        => 'Arvi',
            //     'code'        => 'dlv'. Str::random(5),
            //     'external'    => 1,
            //     'create_time' => Carbon::create('2022', '10', '01'),
            //     'cost_delivery' => 8,
            //     'currency'      => '$',
            // ],
            
        ];

        DB::table('arvi_deliveries')->insert($data);
    }
}
