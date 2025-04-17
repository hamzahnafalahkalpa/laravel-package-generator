<?php

namespace Hanafalah\LaravelPackageGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Hanafalah\LaravelPackageGenerator\Commands;

class CommandServiceProvider extends ServiceProvider
{
    protected $__commands = [
        Commands\InstallMakeCommand::class,
        Commands\GeneratePackageCommand::class
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
