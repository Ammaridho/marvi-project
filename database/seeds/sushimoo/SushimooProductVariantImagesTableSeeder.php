<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooProductVariantImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('product_variant_images')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'variant_id'                    => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'png',
                'image_mime'                    => 'sambal Matah',
                'url'                           => 'url',
            ],
            [
                'merchant_id'                   => 1,
                'variant_id'                    => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'png',
                'image_mime'                    => 'sambal korek',
                'url'                           => 'url',
            ],
            [
                'merchant_id'                   => 1,
                'variant_id'                    => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'image_type'                    => 'png',
                'image_mime'                    => 'sambal ijo',
                'url'                           => 'url',
            ],
            
            
        ];

        DB::table('product_variant_images')->insert($data);
    }
}
