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
        $this->call(UserTableSeeder::class);
        $this->call(ArviDeliveriesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(MerchantAvailableDaysTableSeeder::class);
        $this->call(MerchantProductVariantsTableSeeder::class);
        $this->call(ProductAttributesTableSeeder::class);
        $this->call(ArviPaymentMethodsTableSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CompanyAndBrandSeeder::class);
        $this->call(BrandCategoryTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(MerchantDefinedDelivery::class);
        $this->call(BootstrapSeeder::class);
        $this->call(ArviPaymentProviderSeeder::class);
        $this->call(SetDefaultPaymentOTF::class);
        $this->call(XenditPaymentRelation::class);
        $this->call(UomListTableSeeder::class);
    }
}
