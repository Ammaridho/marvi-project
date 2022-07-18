<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_images')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Black',
                'url'                           => 'url',
                'merchant_product_id'           => 1,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Hojicha-Green-Tea',
                'url'                           => 'url',
                'merchant_product_id'           => 2,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Milk-Manuka',
                'url'                           => 'url',
                'merchant_product_id'           => 3,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Oat-Milk',
                'url'                           => 'url',
                'merchant_product_id'           => 4,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Rooibos-Orange-Tea',
                'url'                           => 'url',
                'merchant_product_id'           => 5,
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'jpg',
                'image_mime'                    => 'Strong-Black-Cold-Brew-Coffee',
                'url'                           => 'url',
                'merchant_product_id'           => 6,
                'active'                        => 1,
            ],
            
        ];

        DB::table('product_images')->insert($data);
    }
}
