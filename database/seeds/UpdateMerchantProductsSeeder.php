<?php

use Illuminate\Database\Seeder;

class UpdateMerchantProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // update sku
        DB::table('merchant_products')->where('id',1)->update(['sku' => 'CBB250']);
        DB::table('merchant_products')->where('id',2)->update(['sku' => 'CBS250']);
        DB::table('merchant_products')->where('id',3)->update(['sku' => 'CBO250']);
        DB::table('merchant_products')->where('id',4)->update(['sku' => 'CBMM250']);
        DB::table('merchant_products')->where('id',5)->update(['sku' => 'CBTH250']);
        DB::table('merchant_products')->where('id',6)->update(['sku' => 'CBTR250']);
    }
}
