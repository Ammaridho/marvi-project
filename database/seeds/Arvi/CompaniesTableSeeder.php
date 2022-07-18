<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => 'PT. Sinar Jaya',
                'create_time' => Carbon::create('2022', '10', '01'),
            ],
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => 'PT. Berkah Jaya',
                'create_time' => Carbon::create('2021', '08', '11'),
            ],
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => $faker->name,
                'create_time' => Carbon::create('2021', '08', '11'),
            ]
        ];

        DB::table('companies')->insert($data);
    }
}
