<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MerchantDefinedDelivery extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchant_defined_deliveries')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'merchant_id'   => 1,
                'name'          => 'Tan Tock Seng Hospital',
                'address'       => 'TTSH Main Building (Blk A) Drop-off Point',
                'loc_lan'       => 0,
                'loc_lat'       => 0,  
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'name'          => 'National Skin Centre',
                'address'       => 'NSC, Room outside Mandalay Clinic',
                'loc_lan'       => 0,
                'loc_lat'       => 0,  
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'name'          => 'Yishun Health Campus',
                'address'       => 'KTPH, B1 Loading Bay',
                'loc_lan'       => 0,
                'loc_lat'       => 0,  
                'postal_code'   => 0,
            ],
            [
                'merchant_id'   => 1,
                'name'          => 'Institute of Mental Health',
                'address'       => 'IMH, Main Block, Main Lobby',
                'loc_lan'       => 0,
                'loc_lat'       => 0,  
                'postal_code'   => 0,
            ],
        ];

        DB::table('merchant_defined_deliveries')->insert($data);
    }
}
