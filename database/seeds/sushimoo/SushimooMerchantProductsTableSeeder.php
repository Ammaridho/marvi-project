<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SushimooMerchantProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('merchant_products')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Mito Platter',
                'description'                   => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad rem, deserunt iste nam illo quas. Sint voluptatum, assumenda similique modi hic commodi eveniet accusantium! Commodi quod pariatur magnam. Dicta, nostrum. ' ,
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 25000,
                'currency'                      => 'Rp ',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Chizu Platter',
                'description'                   => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad rem, deserunt iste nam illo quas. Sint voluptatum, assumenda similique modi hic commodi eveniet accusantium! Commodi quod pariatur magnam. Dicta, nostrum. ' ,
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 22000,
                'currency'                      => 'Rp ',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 4,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Tori Platter',
                'description'                   => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad rem, deserunt iste nam illo quas. Sint voluptatum, assumenda similique modi hic commodi eveniet accusantium! Commodi quod pariatur magnam. Dicta, nostrum. ' ,
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 23000,
                'currency'                      => 'Rp ',
                'active'                        => 1,
            ],
        ];

        DB::table('merchant_products')->insert($data);
    }
}
