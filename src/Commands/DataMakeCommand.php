<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class DataMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-data 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new data using path registry';
    protected $type = 'Schema';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('data.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        return $this->getBaseDataPath().'/'.$this->argument('name').'Data.php';
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
        $this->__replacements['DATA_NAME'] = $this->argument('name');
        $generates_data = $this->__config_generator['patterns'][$this->__pattern]['generates']['data'];
        $generates_data['stub'] = 'data.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates_data,false);

        $this->call('generator:make-data-contract',[
            'name' => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        return $this;
    }

}