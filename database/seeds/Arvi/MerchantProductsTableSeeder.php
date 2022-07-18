<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MerchantProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchant_products')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            // product 1
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Black Coffee',
                'description'                   => 'Our signature black cold brew, ultra-smooth with a naturally sweet chocolatey finish. Zero sugar, zero calories. ',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Strong Black Coffee',
                'description'                   => 'All-natural, full-bodied with bolder flavour to give you the clean energy that you need. Zero sugar, zero calories.',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Oat Milk Coffee',
                'description'                   => 'Creamy, naturally-sweet and refreshingly smooth. Our signature cold brew coffee infused with 100% dairy-free organic oat milk. Shake well for the best experience.',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Milk and Manuka Honey',
                'description'                   => 'Creamy, velvety white coffee with 100% fresh milk lightly sweetened with organic NZ Manuka honey infused with our signature cold brew. An all-time favourite.',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Hojicha Green Tea',
                'description'                   => 'Premium roasted green tea with tasting notes of coffee, roasted barley and caramel. Our cold brew\'s lower caffeine level makes it the perfect refreshment for any time of the day.',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
            [
                'merchant_id'                   => 1,
                'create_time'                   => Carbon::today()->subDays(rand(0, 365)),
                'product_id'                    => 'p'.Str::random(5),
                'name'                          => 'Rooibos Orange Tea',
                'description'                   => 'A naturally sweet copper red infusion of South African rooibos and juicy orange. Brewed cold and slow, lightly sweetened with wildflower honey. This caffeine-free herbal tea is the perfect drink for any time of the day. ',
                'sku'                           => 'mk'.Str::random(5),
                'retail_price'                  => 3.80,
                'currency'                      => '$',
                'active'                        => 1,
            ],
        ];

        DB::table('merchant_products')->insert($data);
    }
}
