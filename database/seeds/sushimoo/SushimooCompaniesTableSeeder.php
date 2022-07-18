<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('companies')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => 'PT SushiMoo',
                'create_time' => Carbon::create('2022', '10', '01'),
            ]
        ];

        DB::table('companies')->insert($data);
    }
}
