<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'mobil_cinta'),
        'passwords' => 'mobil_cinta_accounts',
    ],

    'guards' => [
        'mobil_cinta' => [
            'driver' => 'session',
            'provider' => 'mobil_cinta_accounts',
        ],
    ],

    'providers' => [
        'mobil_cinta_accounts' => [
            'driver' => 'eloquent',
            'model' => App\Models\MobilCinta\Account::class,
        ],
    ],

    'passwords' => [
        'mobil_cinta_accounts' => [
            'provider' => 'mobil_cinta_accounts',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];