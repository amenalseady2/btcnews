<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id'     => '840941109902-6dacseos9a7sna981jd2eejf7mtoc035.apps.googleusercontent.com',
        'client_secret' => '1jAgSaZuUTbjYp5ovBeNKAW8',
        'redirect'      => 'http://5.dev.arabsada.com/passport/getGoogleUser',
    ],

    'facebook' => [
        'client_id'     => '1874107922855401',
        'client_secret' => '203d53d3e0630a6509dbfcfbb5295c27',
        'redirect'      => 'http://5.dev.arabsada.com/passport/getFacebookUser',
    ],

    'twitter' => [
        'client_id'     => 'xq7MpXrCQAhtBdeWcdioffu0W',
        'client_secret' => 'hsfKVYR6zPzeaGB0HPVbJG9sFjILKY67bFloI8cr6BMIcQ6J5r',
        'redirect'      => 'http://5.dev.arabsada.com/passport/getTwitterUser',
    ],

];
