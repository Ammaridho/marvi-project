<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * @DEPRECATED
 */
class PredefinedDeliveryLocations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('predefined_delivery_locations')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'merchant_id'   => 1,
                'address'       => 'TTSH Main Building (Blk A) Drop-off Point',
                'loc_lan'       => 0,
                'loc_lat'       => 0,
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'address'       => 'NSC, Room outside Mandalay Clinic',
                'loc_lan'       => 0,
                'loc_lat'       => 0,
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'address'       => 'KTPH, B1 Loading Bay',
                'loc_lan'       => 0,
                'loc_lat'       => 0,
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'address'       => 'IMH, Main Block, Main Lobby',
                'loc_lan'       => 0,
                'loc_lat'       => 0,
                'postal_code'   => 0,
            ],
        ];

        DB::table('predefined_delivery_locations')->insert($data);
    }
}
