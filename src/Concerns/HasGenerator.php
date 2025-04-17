<?php

namespace Hanafalah\LaravelPackageGenerator\Concerns;

use Hanafalah\LaravelStub\Facades\Stub;
use Illuminate\Support\Str;

trait HasGenerator{
    protected string $__package_name, $__snake_package_name;
    protected array $__stub;
    protected string $__published_at;
    protected string $__open, $__close;
    protected string $__author_email, $__author_name;
    protected array $__generator_lists;



    protected function generateIgnore(): void{
        $this->cardLine('Generating Ignore',function(){
            $path = $this->__published_at;
            $path = Str::replace('/src','',$path);

            Stub::init($this->getIgnoreStubPath(),[
                'CONTENT' => $this->__ignore_content
            ])->saveTo($path,'.gitignore');
        });
    }
}