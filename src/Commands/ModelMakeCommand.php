<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use function Laravel\Prompts\multiselect;
use Illuminate\Support\Str;

class ModelMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-model 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new model using path registry';
    protected $type = 'Model';
    protected $__generates;

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
        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['model'];
        $generates['stub'] = 'model.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);

        $supports = multiselect(
            label: 'Model Support Systems ?',
            options: ['Schema','Controller']
        );
        foreach ($supports as $support) {
            $this->call('generator:make-'.Str::lower($support),[
                'name' => $this->argument('name'),
                '--pattern' => $this->__pattern,
                '--class-basename' => $this->__class_basename
            ]);
        }

        $this->call('generator:make-resource',[
            'name'      => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        $this->call('generator:make-show-resource',[
            'name'      => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        return $this;
    }

}