<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ArviDeliveriesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(MerchantAvailableDaysTableSeeder::class);
        $this->call(MerchantInventoriesTableSeeder::class);
        $this->call(MerchantProductsTableSeeder::class);
        $this->call(MerchantProductVariantsTableSeeder::class);
        $this->call(MerchantsTableSeeder::class);
        $this->call(ProductVariantImagesTableSeeder::class);
        $this->call(ProductImagesTableSeeder::class);
        $this->call(ProductAttributesTableSeeder::class);
        $this->call(ArviPaymentMethodsTableSeeder::class);
        $this->call(MerchantDefinedDelivery::class);

        // Sushimoo
        // $this->call(SushimooCompaniesTableSeeder::class);
        // $this->call(SushimooExtraAtributesTableSeeder::class);
        // $this->call(SushimooMerchantAvailableDaysTableSeeder::class);
        // $this->call(SushimooMerchantInventoriesTableSeeder::class);
        // $this->call(SushimooMerchantProductsTableSeeder::class);
        // $this->call(SushimooMerchantProductVariantsTableSeeder::class);
        // $this->call(SushimooMerchantsTableSeeder::class);
        // $this->call(SushimooProductVariantImagesTableSeeder::class);
        // $this->call(SushimooProductImagesTableSeeder::class);
        // $this->call(SushimooProductAttributesTableSeeder::class);
        // $this->call(SushimooProductCategoryListTableSeeder::class);
        // $this->call(SushimooProductCategoriesTableSeeder::class);
    }
}
