<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('product_images')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Paket-Ayam',
                'url'                           => 'url',
                'merchant_product_id'           => 1,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Paket-Spageti',
                'url'                           => 'url',
                'merchant_product_id'           => 2,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Green-Tea-Float',
                'url'                           => 'url',
                'merchant_product_id'           => 3,
                'active'                        => 1,
            ],
            
        ];

        DB::table('product_images')->insert($data);
    }
}
