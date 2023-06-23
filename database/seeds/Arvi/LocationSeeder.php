<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();

        $data = [
            // product 1
            [
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'name'                          => 'Menara Kuningan',
                'code'                          => 'loc'.Str::random(10),
                'address'                       => 'Jalan Raya Kuningan',
                'building_suite'                => 'Menara',
                'city'                          => 'Jakarta Selatan',
                'state'                         => 'Jakarta',
                'country'                       => 'Indonesia',
                'postal_code'                   => '18091',
                'loc_lat'                       => 111,
                'loc_lon'                       => 222,
                'loc_aware_tolerance'           => '100',
            ],
            
        ];

        DB::table('locations')->insert($data);
    }
}
