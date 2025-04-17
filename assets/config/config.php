<?php

use Hanafalah\LaravelPackageGenerator\{
    Commands,
};

return [
    'libs' => [
        'model'     => 'Models',
        'contract'  => 'Contracts',
        'schema'    => 'Schemas'
    ],
    'namespace'       => env('GENERATOR_NAMESPACE','Modules'),
    'published_at'    => base_path(env('GENERATOR_PUBLISHED_AT','Modules')),
    'generate'        => [
        'migration'       => ['path' => 'Database/Migrations', 'generate' => true],
        'model'           => ['path' => 'Models','generate'=>true],
        'controller'      => ['path' => 'Controllers','generate'=>true],
        'provider'        => ['path' => 'Providers','generate'=>true],
        'config'          => ['path' => 'Config', 'generate' => true],
        'contracts'       => ['path' => 'Contracts', 'generate' => true],
        'concerns'        => ['path' => 'Concerns', 'generate' => true],
        'command'         => ['path' => 'Commands', 'generate' => true],
        'routes'          => ['path' => 'Routes', 'generate' => true],
        'event'           => ['path' => 'Events', 'generate' => false],
        'observer'        => ['path' => 'Observers', 'generate' => true],
        'policies'        => ['path' => 'Policies', 'generate' => true],
        'jobs'            => ['path' => 'Jobs', 'generate' => false],
        'resource'        => ['path' => 'Transformers', 'generate' => false],
        'seeder'          => ['path' => 'Database/Seeders', 'generate' => true],
        'middleware'      => ['path' => 'Middleware', 'generate' => true],
        'request'         => ['path' => 'Requests', 'generate' => true],
        'assets'          => ['path' => 'Resources/assets', 'generate' => true],
        'supports'        => ['path' => 'Supports', 'generate' => true],
        'views'           => ['path' => 'Resources/views', 'generate' => true],
        'schemas'         => ['path' => 'Schemas', 'generate' => true],
        'facades'         => ['path' => 'Facades', 'generate' => true],
        'ignore'          => ['path' => '', 'generate' => true]
    ],
    'stub' => [
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
        ],
    ],
    'database'      => [
        'models'  => [
        ]
    ],
    'commands' => [
        Commands\InstallMakeCommand::class,
        Commands\GeneratePackageCommand::class
    ]
];
