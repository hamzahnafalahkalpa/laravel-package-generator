<?php

namespace Hanafalah\LaravelPackageGenerator\Facades;

use Illuminate\Support\Facades\Facade;
use Hanafalah\LaravelPackageGenerator\Contracts\LaravelPackageGenerator as ContractsLaravelPackageGenerator;

/**
 * @method static void exceptionRespond(Exceptions $exceptions)
 */
class LaravelPackageGenerator extends Facade
{

   protected static function getFacadeAccessor()
   {
      return ContractsLaravelPackageGenerator::class;
   }
}
