<?php

use Illuminate\Database\Seeder;

class UpdateMerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->where('id',1)->update(
            ['description' => '<div class="small" id="pageDesc1">Exclusively For Tan Tock Seng Hospital, National Skin Centre, Yishun Health Campus & Institute of Mental Health</div>
            <div class="small" id="pageDesc2">Cut-off for next day delivery at 8PM daily.</div>',
            'order_days_ahead' => '1']
        );
    }
}
