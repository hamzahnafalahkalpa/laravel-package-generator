<?php

use Illuminate\Support\ServiceProvider;

use Hanafalah\LaravelPackageGenerator\{
    Models,
    Commands,
    Contracts
};

return [
    'libs'    => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'stub'    => [
        /*
        |--------------------------------------------------------------------------
        | Overide hanafalah/laravel-stub
        |--------------------------------------------------------------------------
        |
        | We override the config from "hanafalah/laravel-stub"
        | to customize the stubs for our needs.
        |
        */
        'open_separator'  => '{{',
        'close_separator' => '}}',
        'path'            => stub_path(),
    ],
    'app' => [
        'contracts'     => [
            //ADD YOUR CONTRACTS HERE
            // 'response'         => Contracts\Response::class,
            // 'laravel_package_generator'  => Contracts\LaravelPackageGenerator::class
        ],
    ],
    'database'      => [
        'models'  => [
        ]
    ],
    'class_discovering' => [
        'provider' => [
            'base_classes' => [ServiceProvider::class],
            'paths'        => []
        ],
        'model' => [
            'base_classes' => [],
            'paths'        => []
        ],
        //etc
    ],
    'commands' => [
        Commands\InstallMakeCommand::class,
        Commands\AddPackageCommand::class
    ]
];
