<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class BootstrapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // BOOTSTRAP

        // company
        DB::table('companies')->where('email','bootstrap@gmail.com')->delete();
        $company = [
            [
                'code'        => 'cmp'. 'bootstrap',
                'name'        => 'Bootstrap',
                'email'       => 'bootstrap@gmail.com',
                'country'     => 'Indonesia',
                'create_time' => Carbon::create('2022', '10', '01'),
            ],
        ];
        DB::table('companies')->insert($company);
        

        // brand
        DB::table('brands')->where('name','Bootstrap')->delete();
        $brand = [
            [
                'company_id'  => DB::table('companies')->where('email','bootstrap@gmail.com')->first()->id,
                'code'        => 'br'. 'bootstrap',
                'name'        => 'Bootstrap',
                'country'     => 'Indonesia',
                'create_time' => Carbon::create('2022', '10', '01'),
            ],
        ];
        DB::table('brands')->insert($brand);


        // merchant
        DB::table('merchants')->delete();

        $faker = Faker::create('id_ID');

        $data = [
            [
                'create_time'           => Carbon::today()->addDays(rand(1, 365)),
                'code'                  => 'mrc'. 'asdfghjkl',
                'name'                  => 'Bootstrap',
                'loc_aware'             => 1,
                'loc_lon'               => 0,
                'loc_lat'               => 0,
                'description'           => 'ini adalah toko minuman coffee',
                'address'               => $faker->address,
                'city'                  => $faker->city,
                'country'               => $faker->country,
                'postal_code'           => $faker->postcode,
                'location_label'        => $faker->streetSuffix,
                'loc_aware_tolerance'   => 0,
                'loc_aware_uom'         => 0,
                'company_id'            => 1,
                'order_days_ahead'      => 1,
                'active'                => 1, 

            ],
        ];

        DB::table('merchants')->insert($data);

        // brand_product
        DB::table('brand_products')->delete();
        $data = [
            // product 1
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Black Coffee',
                'description'      => 'Our signature black cold brew, ultra-smooth with a naturally sweet chocolatey finish. Zero sugar, zero calories. ',
                'sku'              => 'CBB250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Strong Black Coffee',
                'description'      => 'All-natural, full-bodied with bolder flavour to give you the clean energy that you need. Zero sugar, zero calories.',
                'sku'              => 'CBS250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Oat Milk Coffee',
                'description'      => 'Creamy, naturally-sweet and refreshingly smooth. Our signature cold brew coffee infused with 100% dairy-free organic oat milk. Shake well for the best experience.',
                'sku'              => 'CBO250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Milk and Manuka Honey',
                'description'      => 'Creamy, velvety white coffee with 100% fresh milk lightly sweetened with organic NZ Manuka honey infused with our signature cold brew. An all-time favourite.',
                'sku'              => 'CBMM250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Hojicha Green Tea',
                'description'      => 'Premium roasted green tea with tasting notes of coffee, roasted barley and caramel. Our cold brew\'s lower caffeine level makes it the perfect refreshment for any time of the day.',
                'sku'              => 'CBTH250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
            [
                'brand_id'         => DB::table('brands')->where('name','Bootstrap')->first()->id,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'product_id'       => 'p'.Str::random(5),
                'name'             => 'Rooibos Orange Tea',
                'description'      => 'A naturally sweet copper red infusion of South African rooibos and juicy orange. Brewed cold and slow, lightly sweetened with wildflower honey. This caffeine-free herbal tea is the perfect drink for any time of the day. ',
                'sku'              => 'CBTR250',
                'retail_price'     => 10000,
                'currency'         => 'IDR',
                'active'           => 1,
            ],
        ];

        DB::table('brand_products')->insert($data);


        // images
        DB::table('brand_images')->delete();

        $data = [
            // product 1
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Black',
                'url'              => 'url',
                'brand_product_id' => 1,
                'active'           => 1,
            ],
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Hojicha-Green-Tea',
                'url'              => 'url',
                'brand_product_id' => 2,
                'active'           => 1,
            ],
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Milk-Manuka',
                'url'              => 'url',
                'brand_product_id' => 3,
                'active'           => 1,
            ],
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Oat-Milk',
                'url'              => 'url',
                'brand_product_id' => 4,
                'active'           => 1,
            ],
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Rooibos-Orange-Tea',
                'url'              => 'url',
                'brand_product_id' => 5,
                'active'           => 1,
            ],
            [
                'brand_id'         => 1,
                'create_time'      => Carbon::today()->subDays(rand(0, 365)),
                'image_type'       => 'jpg',
                'image_mime'       => 'Strong-Black-Cold-Brew-Coffee',
                'url'              => 'url',
                'brand_product_id' => 6,
                'active'           => 1,
            ],
            
        ];

        DB::table('brand_images')->insert($data);

        // merchant
        DB::table('merchants')->where('name', 'Bootstrap')
            ->update(['company_id'  => DB::table('companies')->where('email','bootstrap@gmail.com')->first()->id, 
                        'brand_id'    => DB::table('brands')->where('name','Bootstrap')->first()->id]);
        

    }
}
