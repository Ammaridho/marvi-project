<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CompanyAndBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $dataCompanies = [
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => 'PT. Jaya Ayam',
                'create_time' => Carbon::create('2022', '10', '01'),
                'email'       => 'jayaayam@gmail.com',
                'country'     => 'Indonesia'
            ],
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => 'PT. Jaya BoBaa',
                'create_time' => Carbon::create('2021', '08', '11'),
                'email'       => 'jayabobaa@gmail.com',
                'country'     => 'Indonesia'
            ],
            [
                'code'        => 'cmp'. Str::random(5),
                'name'        => $faker->name,
                'create_time' => Carbon::create('2021', '08', '11'),
                'email'       => 'ptabaru@gmail.com',
                'country'     => 'Indonesia'
            ]
        ];

        DB::table('companies')->insert($dataCompanies);

        $dataBrands = [
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya Ayam')->first()->id,
                'code'        => 'br'. Str::random(5),
                'name'        => 'Ayam Bakar SUPriyadi',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya BoBaa')->first()->id,
                'code'        => 'br'. Str::random(5),
                'name'        => 'BoBaa SUPriyadi',
                'create_time' => Carbon::create('2021', '08', '11'),
                'country'     => 'Indonesia'
            ]
        ];

        DB::table('brands')->insert($dataBrands);

        $dataMerchants = [
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya Ayam')->first()->id,
                'brand_id'    => DB::table('brands')->where('name','Ayam Bakar SUPriyadi')->first()->id,
                'code'        => 'mrc'. Str::random(5),
                'name'        => 'Menara Kuningan',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya Ayam')->first()->id,
                'brand_id'    => DB::table('brands')->where('name','Ayam Bakar SUPriyadi')->first()->id,
                'code'        => 'mrc'. Str::random(5),
                'name'        => 'Menara Mall Ambasador',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya Ayam')->first()->id,
                'brand_id'    => DB::table('brands')->where('name','Ayam Bakar SUPriyadi')->first()->id,
                'code'        => 'mrc'. Str::random(5),
                'name'        => 'Margonda Depok',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya BoBaa')->first()->id,
                'brand_id'    => DB::table('brands')->where('name','BoBaa SUPriyadi')->first()->id,
                'code'        => 'mrc'. Str::random(5),
                'name'        => 'Menara Kuningan',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
            [
                'company_id'  => DB::table('companies')->where('name','PT. Jaya BoBaa')->first()->id,
                'brand_id'    => DB::table('brands')->where('name','BoBaa SUPriyadi')->first()->id,
                'code'        => 'mrc'. Str::random(5),
                'name'        => 'Bekasi',
                'create_time' => Carbon::create('2022', '10', '01'),
                'country'     => 'Indonesia'
            ],
        ];

        DB::table('merchants')->insert($dataMerchants);

        // set users admin to superadmin
        DB::table('users')->where('email','admin@gmail.com')->update(['role' => 'superadmin']);
    }
}
