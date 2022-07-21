<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OTF Related i18n
    |--------------------------------------------------------------------------
    |
    */

    'validation' => [
        'invalid_parameter'   => 'Invalid supplied parameter',
        'missing_parameter'   => 'Missing required parameter',
        'name_invalid'   => 'Please input the right name. It cannot be empty',
        'phone_invalid'  => 'Please input valid Phone number',
        'email_invalid'  => 'Please input a valid email',
    ],
    'failed_payment' => "Sorry, we're unable to process payment at the moment. Please try again later",
    'email' => [
        'sender' => 'Oobe.ai',
        'failed' => [
            'subject' => '[:merchant] Order Payment Failed :order'
        ],
        'success' => [
            'subject' => '[:merchant] Order Payment Success :order'
        ]
    ]
];
