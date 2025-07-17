<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class MigrationMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-migration 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new data using path registry';
    protected $type = 'Route';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('migration.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        $prefix = date('Y_m_d').'_000000_create_';
        return $this->getBaseMigrationPath()."/".$prefix.Str::plural(Str::snake($this->argument('name'))).'_table.php';
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
        $generates = $this->__config_generator['patterns'][$this->__pattern]['generates']['migration'];
        $generates['stub'] = 'migration.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates,false);
        return $this;
    }

}