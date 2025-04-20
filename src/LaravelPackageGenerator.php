<?php

namespace Hanafalah\LaravelPackageGenerator;

use Hanafalah\LaravelPackageGenerator\Contracts\LaravelPackageGenerator as ContractsLaravelPackageGenerator;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class LaravelPackageGenerator extends PackageManagement implements ContractsLaravelPackageGenerator
{
    public function runApplications(string|array $projects): void{
        $projects = $this->mustArray($projects);
        foreach ($projects as $project) {
            if ((request()->hasHeader('appcode') || config('app.dev-mode')) && !app()->isDownForMaintenance()){
                $path = config("laravel-package-generator.{$project['type']}.published_at").DIRECTORY_SEPARATOR.$project['name'];
                require $path.'/vendor/autoload.php';
                app()->register($this->replacement($project['provider']));
            }
        }
    }
}
