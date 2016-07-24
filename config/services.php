<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => lexpoint\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => '2321e5ebacece074af4a',
        'client_secret' => '66a91ffc3019bf7794448c61584ff1685dd4a41c',
        'redirect' => 'http://lexpoint.krc.karelia.ru/socialite/github/callback', 
    ],

    'google' => [
        'client_id' => '596005242313-41cr569aknhnpgjqkud3lk1gh9qg1l5b.apps.googleusercontent.com', 
        'client_secret' => 'gMBwHgLJehCGR-8lt80Jw9uE',
        'redirect' => 'http://lexpoint.krc.karelia.ru/socialite/google/callback', 
    ],
];
