<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class RouteMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-route 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new data using path registry';
    protected $type = 'Route';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('api-resource.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        $name = $this->argument('name');
        return $this->getBaseRoutePath().'/api/'.Str::snake($name,'-').'.php';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $this->initGenerator()->setLibs();
        $this->initiateLibsReplacement();
        $this->__replacements['CONTROLLER_NAME'] = $this->argument('name');
        $this->__replacements['SNAKE_CONTROLLER_NAME'] = Str::snake($this->argument('name'),'-');
        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['route'];
        $generates['stub'] = 'api-resource.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);
        return $this;
    }

}