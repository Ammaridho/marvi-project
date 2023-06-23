<?php

use Illuminate\Database\Seeder;

class PaymentBootstrapBeverages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code = 'mrcDVRw9UUdYq';
        $data = [
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','BCA')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','BRI')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','BNI')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','Permata')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','Alfamart')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','OVO')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','DANA')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','LinkAja')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','Visa')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','Mastercard')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','JCB')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
            [
                'merchant_id'           => DB::table('merchants')->where('code',$code)->first()->id,
                'payment_method_id'     => DB::table('arvi_payment_methods')->where('name','QRIS')->first()->id,
                'payment_provider_id'   => DB::table('arvi_payment_providers')->where('name','Xendit')->first()->id,
                'active'                => 1,
                'fee'                   => 0,
                'is_fee_percentage'     => 0,
                'currency'              => 'IDR',
            ],
        ];

        DB::table('merchant_payments')->insert($data);
    }
}
