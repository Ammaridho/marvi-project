<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooExtraAtributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // product 1
        $data = [
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'type'                          => 'Condiments',
                'name'                          => 'Shoyu',
                'fee'                           => 2000,
                'currency'                      => 'Rp',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'type'                          => 'Condiments',
                'name'                          => 'Togarashi',
                'fee'                           => 3000,
                'currency'                      => 'Rp',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'type'                          => 'Cutlery',
                'name'                          => 'Sumpit',
                'fee'                           => 3000,
                'currency'                      => 'Rp',
                'active'                        => 1,
            ],
        ];   

        DB::table('extra_attributes')->insert($data);
    }
}
