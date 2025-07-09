<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

use function Laravel\Prompts\text;

class RequestMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-request 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}
                {--model-name= : Pattern yang digunakan}';
    protected $description = 'Create a new data using path registry';
    protected $type = 'Route';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('request.php.stub');
    }

    protected function getPath($name): string{
        $model_name = $this->option('model-name') 
        ?? text(
            label: 'Tolong isi nama model:',
            placeholder: 'Contoh: Employee',
            required: true
        );
        
        if (!isset($this->__namespace)) $this->choosePattern();
        $name = $this->argument('name');
        $this->__replacements['MODEL_NAME'] = $model_name;
        return $this->getBaseRequestPath()."/API/{$model_name}/".Str::studly($name).'Request.php';
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
        $this->__replacements['REQUEST_NAME'] = $this->argument('name');
        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['request'];
        $generates['stub'] = 'request.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);
        return $this;
    }

}