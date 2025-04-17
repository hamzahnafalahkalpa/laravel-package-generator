<?php

namespace Hanafalah\LaravelPackageGenerator;

use Hanafalah\LaravelPackageGenerator\Contracts;
use Hanafalah\LaravelPackageGenerator\LaravelPackageGenerator;
use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class LaravelPackageGeneratorServiceProvider extends BaseServiceProvider
{
  public function register()
  {
    $this->registerMainClass(LaravelPackageGenerator::class)
      ->registerCommandService(Providers\CommandServiceProvider::class)
      ->registers([
        '*',
        'Config',
        'Namespace' => function(){
          $this->publishes([
            $this->getAssetPath('templates') => template_base_path(),
          ], 'template');
        }
      ])
      ->appBooting(function ($app) {
        config(['laravel-stub.stub' => config('laravel-package-generator.stub')]);
      });
  }

  public function boot(){
    $this->paramSetup();
  }

  protected function dir(): string{
    return __DIR__ . '/';
  }
}
