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
    'published_at'    => base_path(env('GENERATOR_PUBLISHED_AT','Modules')),
    'namespace'       => base_path(env('GENERATOR_NAMESPACE','Modules')),
    'patterns'        => [
        'repository' => [
            //files has same structure with main generate
            'generates' => [
                'asset'             => ['type' => 'dir','path' => '../assets', 'generate' => true, 'stub' => null, 'files'=>[]],
                'config'            => ['type' => 'dir','path' => '../assets/config', 'generate' => true, 'stub' => null, 'files'=>[
                    'config'        => ['generate' => true, 'stub' => 'repo-config.php.stub']
                ]],
                'migration'         => ['type' => 'dir','path' => '../assets/database/migrations', 'generate' => true, 'stub' => null, 'files'=>[]],
                'model'             => ['type' => 'dir','path' => 'Models','generate' => true, 'stub' => null, 'files'=>[]],
                'controller'        => ['type' => 'dir','path' => 'Controllers','generate' => false, 'stub' => null, 'files'=>[]],
                'provider'          => ['type' => 'dir','path' => 'Providers','generate' => true, 'stub' => null, 'files'=>[
                    'CommandServiceProvider' => ['generate' => true, 'stub' => 'CommandServiceProvider.php.stub'],
                ]],
                'contract'          => ['type' => 'dir','path' => 'Contracts', 'generate' => true, 'stub' => null, 'files'=>[]],
                'concern'           => ['type' => 'dir','path' => 'Concerns', 'generate' => true, 'stub' => null, 'files'=>[]],
                'command'           => ['type' => 'dir','path' => 'Commands', 'generate' => true, 'stub' => null, 'files'=>[
                    'InstallMakeCommand' => ['generate' => true, 'stub' => 'InstallMakeCommand.php.stub'],
                    'EnvironmentCommand' => ['generate' => true, 'stub' => 'repo-EnvironmentCommand.php.stub']
                ]],
                'route'             => ['type' => 'dir','path' => 'Routes', 'generate' => true, 'stub' => null, 'files'=>[]],
                'event'             => ['type' => 'dir','path' => 'Events', 'generate' => false, 'stub' => null, 'files'=>[]],
                'observer'          => ['type' => 'dir','path' => 'Observers', 'generate' => false, 'stub' => null, 'files'=>[]],
                'policy'            => ['type' => 'dir','path' => 'Policies', 'generate' => false, 'stub' => null, 'files'=>[]],
                'job'               => ['type' => 'dir','path' => 'Jobs', 'generate' => false, 'stub' => null, 'files'=>[]],
                'resource'          => ['type' => 'dir','path' => 'Resources', 'generate' => true, 'stub' => null, 'files'=>[]],
                'seeder'            => ['type' => 'dir','path' => 'Database/Seeders', 'generate' => true, 'stub' => null, 'files'=>[]],
                'middleware'        => ['type' => 'dir','path' => 'Middleware', 'generate' => true, 'stub' => null, 'files'=>[]],
                'request'           => ['type' => 'dir','path' => 'Requests', 'generate' => false, 'stub' => null, 'files'=>[]],
                'support'           => ['type' => 'dir','path' => 'Supports', 'generate' => true, 'stub' => null, 'files'=>[
                    'Base{{CLASS_BASENAME}}' => ['generate' => true, 'stub' => 'BaseSupport.php.stub']
                ]],
                'view'              => ['type' => 'dir','path' => 'Views', 'generate' => false, 'stub' => null, 'files'=>[]],
                'schema'            => ['type' => 'dir','path' => 'Schemas', 'generate' => true, 'stub' => null, 'files'=>[]],
                'facade'            => ['type' => 'dir','path' => 'Facades', 'generate' => true, 'stub' => null, 'files'=>[
                    '{{CLASS_BASENAME}}' => ['generate' => true, 'stub' => 'ModuleFacade.php.stub']
                ]],
                'gitignore'         => ['filename' => '.gitignore','type' => 'file','path' => '../', 'generate' => true, 'stub' => '.gitignore.stub', 'files'=>[]],
                'composer'          => ['type' => 'file','path' => '../', 'generate' => true, 'stub' => 'composer.json.stub', 'files'=>[]],
                'helper'            => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'helper.php.stub', 'files'=>[]],

                //FILE
                //`{{` `}}` SAMA KAN DENGAN STUB SEPARATOR (open, close)
                '{{CLASS_BASENAME}}ServiceProvider' => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'repo-main-provider.php.stub'],
                '{{CLASS_BASENAME}}'                => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'repo-main-class.php.stub'],
            ],
            'executes' => [
                [
                    'ModelMakeCommand' => [
                        // 'command' => 
                    ]
                ]
            ]
        ],
        'project'     => [
            'generates' => [
                'migration'       => ['type' => 'dir','path' => 'Database/Migrations', 'generate' => true, 'stub' => null, 'files' => []],
                'model'           => ['type' => 'dir','path' => 'Models','generate' => true, 'stub' => null, 'files' => []],
                'controller'      => ['type' => 'dir','path' => 'Controllers','generate' => true, 'stub' => null, 'files' => []],
                'provider'        => ['type' => 'dir','path' => 'Providers','generate' => true, 'stub' => null, 'files' => [
                    'CommandServiceProvider' => ['generate' => true, 'stub' => 'CommandServiceProvider.php.stub'],
                    'RouteServiceProvider'   => ['generate' => true, 'stub' => 'RouteServiceProvider.php.stub'],
                    '{{CLASS_BASENAME}}Environment' => ['generate' => true, 'stub' => 'project-EnvironmentServiceProvider.php.stub'],
                    '{{CLASS_BASENAME}}ServiceProvider' => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'project-main-provider.php.stub'],
                ]],
                'contract'        => ['type' => 'dir','path' => 'Contracts', 'generate' => true, 'stub' => null, 'files' => [
                    '{{CLASS_BASENAME}}'  => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'main-contract.php.stub'],
                ]],
                'concern'         => ['type' => 'dir','path' => 'Concerns', 'generate' => true, 'stub' => null, 'files' => []],
                'command'         => ['type' => 'dir','path' => 'Commands', 'generate' => true, 'stub' => null, 'files' => [
                    'InstallMakeCommand' => ['generate' => true, 'stub' => 'InstallMakeCommand.php.stub'],
                    'EnvironmentCommand' => ['generate' => true, 'stub' => 'project-EnvironmentCommand.php.stub']
                ]],
                'route'           => ['type' => 'dir','path' => 'Routes', 'generate' => true, 'stub' => null, 'files' => []],
                'event'           => ['type' => 'dir','path' => 'Events', 'generate' => false, 'stub' => null, 'files' => []],
                'observer'        => ['type' => 'dir','path' => 'Observers', 'generate' => true, 'stub' => null, 'files' => []],
                'policy'          => ['type' => 'dir','path' => 'Policies', 'generate' => true, 'stub' => null, 'files' => []],
                'job'             => ['type' => 'dir','path' => 'Jobs', 'generate' => false, 'stub' => null, 'files' => []],
                'resource'        => ['type' => 'dir','path' => 'Resources', 'generate' => false, 'stub' => null, 'files' => []],
                'seeder'          => ['type' => 'dir','path' => 'Database/Seeders', 'generate' => true, 'stub' => null, 'files' => []],
                'middleware'      => ['type' => 'dir','path' => 'Middleware', 'generate' => true, 'stub' => null, 'files' => []],
                'request'         => ['type' => 'dir','path' => 'Requests', 'generate' => true, 'stub' => null, 'files' => []],
                'support'         => ['type' => 'dir','path' => 'Supports', 'generate' => true, 'stub' => null, 'files' => [
                    'PathRegistry' => ['generate' => true, 'stub' => 'PathRegistry.php.stub'],
                    'LocalPath'    => ['generate' => true, 'stub' => 'LocalPath.php.stub']
                ]],
                'view'            => ['type' => 'dir','path' => 'Views', 'generate' => true, 'stub' => null, 'files' => []],
                'schema'          => ['type' => 'dir','path' => 'Schemas', 'generate' => true, 'stub' => null, 'files' => []],
                'facade'          => ['type' => 'dir','path' => 'Facades', 'generate' => true, 'stub' => null, 'files' => [
                    '{{CLASS_BASENAME}}' => ['generate' => true, 'stub' => 'ModuleFacade.php.stub']
                ]],
                'config'          => ['type' => 'dir','path' => 'Config', 'generate' => true, 'stub' => null, 'files' => [
                    'config'        => ['generate' => true, 'stub' => 'project-config.php.stub']
                ]],

                //FILE
                'gitignore'          => ['filename' => '.gitignore','type' => 'file','path' => '', 'generate' => true, 'stub' => '.gitignore.stub'],
                '{{CLASS_BASENAME}}'  => ['type' => 'file','path' => '', 'generate' => true, 'stub' => 'project-main-class.php.stub'],
            ],
        ]
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
        'path'            => base_path('stubs/LaravelPackageGeneratorStubs'),
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
        Commands\ModelMakeCommand::class,
        Commands\GeneratePackageCommand::class
    ]
];
