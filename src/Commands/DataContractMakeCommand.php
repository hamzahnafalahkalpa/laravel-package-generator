<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class DataContractMakeCommand extends SchemaContractMakeCommand
{
    protected $signature = 'generator:make-data-contract 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new contract using path registry';
    protected $type = 'Data Contract';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('data-contract.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        $path = $this->__config_basename['libs']['data'];
        return $this->getBaseContractPath().'/'.$path.'/'.$this->argument('name').'Data.php';
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
        $this->__replacements['CONTRACT_NAME'] = $this->argument('name');

        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates'];
        $generates['contract']['stub'] = 'data-contract.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates['contract'],false);
        return $this;
    }

}