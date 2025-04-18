<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;
use Illuminate\Support\Str;

class ModelMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-model {name} {namespace}';
    protected $description = 'Create a new model using path registry';
    protected $type = 'Model';

    protected function getStub()
    {
        return generator_stub_path('model.php.stub');
    }

    protected function rootNamespace(){
        return $this->argument('namespace');
    }

    protected function getPath($name): string{
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->resolvePath('model', $name);
    }
}