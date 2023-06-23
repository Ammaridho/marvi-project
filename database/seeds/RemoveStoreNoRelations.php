<?php

use Illuminate\Database\Seeder;

class RemoveStoreNoRelations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // brand
        DB::table('merchants')
        ->whereIn('name',array(
            'Baso Tak Terduga', 
            'Mie Ayam Donoloyo',
            'Menara Kuningan',
            'Menara Mall Ambasador',
            'Margonda Depok',
            'Bekasi',
            'asd & sda',
            `' !  2' 32@#$%^&*()_+asd<>?""}`,
        ))->delete();
    }
}
