<?php

namespace Hanafalah\LaravelPackageGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Hanafalah\LaravelPackageGenerator\Commands;

class CommandServiceProvider extends ServiceProvider
{
    protected $__commands = [
        Commands\ControllerMakeCommand::class,
        Commands\DataContractMakeCommand::class,
        Commands\DataMakeCommand::class,
        Commands\GeneratePackageCommand::class,
        Commands\InstallMakeCommand::class,
        Commands\MigrationMakeCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\ResourceMakeCommand::class,
        Commands\RequestMakeCommand::class,
        Commands\RouteMakeCommand::class,
        Commands\SchemaContractMakeCommand::class,
        Commands\SchemaMakeCommand::class,
        Commands\ShowResourceMakeCommand::class,
    ];

    public function register()
    {
        $this->commands(config('laravel-package-generator.commands', $this->__commands));
    }

    public function provides()
    {
        return $this->__commands;
    }
}
