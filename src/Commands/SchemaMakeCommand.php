<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class SchemaMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-schema 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new schema using path registry';
    protected $type = 'Schema';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('schema.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        return $this->getBaseSchemaPath().'/'.$this->argument('name').'.php';
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
        $this->__replacements['SCHEMA_NAME'] = $this->argument('name');
        $this->__replacements['LOWER_SCHEMA_NAME'] = Str::lower($this->argument('name'));
        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['schema'];
        $generates['stub'] = 'schema.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);

        $this->call('generator:make-data',[
            'name'      => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        $this->call('generator:make-schema-contract',[
            'name'      => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        return $this;
    }

}