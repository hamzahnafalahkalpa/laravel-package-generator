<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class ResourceMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-resource 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new resource using path registry';
    protected $type = 'Resource';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('ViewResource.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        return $this->getBaseResourcePath().'/'.$this->argument('name').'/View'.$this->argument('name').'.php';
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
        $this->__replacements['RESOURCE_NAME'] = $this->argument('name');

        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['resource'];
        $generates['stub'] = 'ViewResource.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);
        return $this;
    }

}