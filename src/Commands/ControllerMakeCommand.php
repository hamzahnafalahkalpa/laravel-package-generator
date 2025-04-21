<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelSupport\Commands\BaseCommand;

use Illuminate\Support\Str;

class ControllerMakeCommand extends BaseCommand
{
    protected $signature = 'generator:make-controller 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
    protected $description = 'Create a new data using path registry';
    protected $type = 'Controller';
    protected $__generates;

    protected function getStub()
    {
        return generator_stub_path('controller.php.stub');
    }

    protected function getPath($name): string{
        if (!isset($this->__namespace)) $this->choosePattern();
        return $this->getBaseControllerPath().'/'.$this->argument('name').'Controller.php';
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
        $this->__replacements['LOWER_CONTROLLER_NAME'] = Str::lower($this->argument('name'));
        $generates_data = $this->__config_generator['patterns'][$this->__pattern]['generates']['controller'];
        $generates_data['stub'] = 'controller.php.stub';
        $stub = $this->generateFile($this->argument('name'),$generates_data,false);

        $this->call('generator:make-route',[
            'name' => $this->argument('name'),
            '--pattern' => $this->__pattern,
            '--class-basename' => $this->__class_basename
        ]);

        $requests = ['View','Store','Show','Delete'];
        foreach ($requests as $request_name) {
            $this->call('generator:make-request',[
                'name' => $request_name,
                '--model-name' => $this->argument('name'),
                '--pattern' => $this->__pattern,
                '--class-basename' => $this->__class_basename
            ]);
        }

        return $this;
    }

}