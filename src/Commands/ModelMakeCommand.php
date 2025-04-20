<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

class ModelMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-model 
                {name}
                {--pattern= : Pattern yang digunakan}';
    protected $description = 'Create a new model using path registry';
    protected $type = 'Model';

    protected function getStub()
    {
        return generator_stub_path('model.php.stub');
    }

    // protected function rootNamespace(){
    //     if (!isset($this->__namespace)) $this->choosePattern();
    //     return $this->__namespace;
    // }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        return $this->getBaseModelPath().'/'.$this->argument('name').'.php';
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
        $this->__replacements['MODEL_NAME'] = $this->argument('name');
        $this->__replacements['LIST'] = ['id','props'];
        $this->__replacements['BOOTED_SECTION'] = null;
        $this->__replacements['SCOPE_SECTION'] = null;
        $this->__replacements['EIGER_SECTION'] = null;
        $stub = $this->generateFile($this->argument('name'),$this->__config_generator['patterns'][$this->__pattern]['generates']['model']);

        return $this;
    }

}