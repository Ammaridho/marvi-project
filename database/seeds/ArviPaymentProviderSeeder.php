<?php

use Illuminate\Database\Seeder;

class ArviPaymentProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ex =
            \App\Models\Payments\ArviPaymentProvider::where('id',\App\Models\Payments\ArviPaymentProvider::UNKNOWN)
            ->first();
        if (!$ex) {
            \App\Models\Payments\ArviPaymentProvider::create(
                [
                    'id'          => \App\Models\Payments\ArviPaymentProvider::UNKNOWN,
                    'name'        => 'Unknown',
                    'create_time' => \Carbon\Carbon::now(),
                    'update_time' => \Carbon\Carbon::now(),
                    'active'      => 1,
                ]
            );
        }

        $ex =
            \App\Models\Payments\ArviPaymentProvider::where('id',\App\Models\Payments\ArviPaymentProvider::STRIPE)
                ->first();
        if (!$ex) {
            \App\Models\Payments\ArviPaymentProvider::create(
                [
                    'id'          => \App\Models\Payments\ArviPaymentProvider::STRIPE,
                    'name'        => 'Stripe',
                    'url'         => 'https://stripe.com/',
                    'create_time' => \Carbon\Carbon::now(),
                    'update_time' => \Carbon\Carbon::now(),
                    'active'      => 1,
                ]
            );
        }

        $ex =
            \App\Models\Payments\ArviPaymentProvider::where('id',\App\Models\Payments\ArviPaymentProvider::DOKU)
                ->first();
        if (!$ex) {
            \App\Models\Payments\ArviPaymentProvider::create(
                [
                    'id'          => \App\Models\Payments\ArviPaymentProvider::DOKU,
                    'name'        => 'Doku',
                    'url'         => 'https://doku.com/',
                    'create_time' => \Carbon\Carbon::now(),
                    'update_time' => \Carbon\Carbon::now(),
                    'active'      => 1,
                ]
            );
        }

        $ex =
            \App\Models\Payments\ArviPaymentProvider::where('id',\App\Models\Payments\ArviPaymentProvider::MIDTRANS)
                ->first();
        if (!$ex) {
            \App\Models\Payments\ArviPaymentProvider::create(
                [
                    'id'          => \App\Models\Payments\ArviPaymentProvider::MIDTRANS,
                    'name'        => 'Midtrans',
                    'url'         => 'https://midtrans.com/',
                    'create_time' => \Carbon\Carbon::now(),
                    'update_time' => \Carbon\Carbon::now(),
                    'active'      => 1,
                ]
            );
        }

        $ex =
            \App\Models\Payments\ArviPaymentProvider::where('id',\App\Models\Payments\ArviPaymentProvider::XENDIT)
                ->first();
        if (!$ex) {
            \App\Models\Payments\ArviPaymentProvider::create(
                [
                    'id'          => \App\Models\Payments\ArviPaymentProvider::XENDIT,
                    'name'        => 'Xendit',
                    'url'         => 'https://xendit.com/',
                    'create_time' => \Carbon\Carbon::now(),
                    'update_time' => \Carbon\Carbon::now(),
                    'active'      => 1,
                ]
            );
        }
    }
}
