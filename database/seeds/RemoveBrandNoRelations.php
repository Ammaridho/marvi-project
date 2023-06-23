<?php

use Illuminate\Database\Seeder;

class RemoveBrandNoRelations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // brand
        DB::table('brands')
        ->whereIn('name',array(
            'asd',
        ))->delete();
    }
}
