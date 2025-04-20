<?php

namespace Hanafalah\LaravelPackageGenerator\Concerns;

use Hanafalah\LaravelPackageGenerator\Concerns\GeneratorPath;
use Hanafalah\LaravelStub\Facades\Stub;
use Illuminate\Support\Str;

use function Laravel\Prompts\{
    select
};

trait HasGenerator{
    use PromptLayout;
    use GeneratorPath;

    protected array $__stub;
    protected string $__published_at;
    protected string $__base_stub;
    protected string $__at_source, $__relative_path;
    protected string $__open, $__close;
    protected array $__generator_lists, $__config, $__replacements = [];
    protected mixed $__namespace, $__class_basename, 
        $__first_namespace,
        $__snake_class_basename,
        $__snake_lower_class_basename,
        $__author_name,
        $__author_email, $__libs = [];

    protected function getPublishedAt(): string{
        return $this->__published_at;
    }

    protected function getPackageSource(string $path): string{
        return $this->__published_at.DIRECTORY_SEPARATOR.$this->__class_basename.DIRECTORY_SEPARATOR.'src/'.$path;
    }

    protected function getBaseStub(): string{
        return $this->__base_stub;
    }

    public function init():self{
        $this->readPackageBasename()
             ->initConfig()
             ->initiateStub()
             ->initiateAuthor()
             ->initiateReplacement();
        return $this;
    }

    protected function readPackageBasename(): self{
        $this->__namespace                  = Str::replace('/','\\',$this->argument('namespace'));
        $this->__class_basename             = $class_basename = Str::afterLast($this->__namespace,'\\');
        $this->__snake_class_basename       = Str::snake($class_basename,'-');
        $this->__snake_lower_class_basename = Str::snake($class_basename);
        $this->__replacements['NAMESPACE']  = $this->__namespace;
        $namespaces = explode('\\',$this->__namespace);
        foreach ($namespaces as $key => &$namespace) {
            if ($key == 0) $this->__first_namespace = $namespace;
            $namespace = Str::snake($namespace,'-');
        }
        $this->__replacements['FIRST_NAMESPACE']            = $this->__first_namespace;
        $this->__replacements['SNAKE_NAMESPACE']            = implode('\\\\',$namespaces);
        $this->__replacements['CLASS_BASENAME']             = $class_basename;
        $this->__replacements['SNAKE_LOWER_CLASS_BASENAME'] = $this->__snake_lower_class_basename;
        $this->__replacements['SNAKE_CLASS_BASENAME']       = $this->__snake_class_basename;
        return $this;
    }

    protected function initConfig(): self{
        $this->__config = config('laravel-package-generator');
        return $this;
    }

    protected function initiateStub(): self{
        $this->__stub      = config('laravel-stub.stub');
        $this->__open      = preg_quote($this->__stub['open_separator'], '/');
        $this->__close     = preg_quote($this->__stub['close_separator'], '/');
        $this->__base_stub = generator_stub_path();
        
        return $this;
    }

    protected function initiateAuthor(): self{
        $this->__author_name  = cache()->rememberForever('package-author', function() {
            return $this->option('package-author') ?? $this->ask('Tolong isi nama author:');
        });
        
        $this->__author_email = cache()->rememberForever('package-email', function() {
            return $this->option('package-email') ?? $this->ask('Tolong isi email author:');
        });

        $this->info('Author: '.$this->__author_name.' ('.$this->__author_email.')');
        return $this;
    }

    protected function initiateReplacement(): self{
        $this->__replacements = array_merge($this->__replacements,[
            'AUTHOR_NAME'          => $this->__author_name ?? null,
            'AUTHOR_EMAIL'         => $this->__author_email ?? null,
            'LIBS'                 => $this->__libs ?? []
        ]);
        return $this;
    }

    protected function setReplacement(string $key, mixed $value): array{
        $this->__replacements[$key] = $value;
        return $this->__replacements;
    }

    protected function makeDir(string $relative_path){
        if (!is_dir($relative_path)) mkdir($relative_path, 0777, true);
        return $relative_path;
    }

    private function generate(): self{
        $config = config('laravel-package-generator');        
        $pattern  = $this->option('pattern');
        if (!isset($pattern)){
            $patterns = array_keys($config['patterns']);
            $pattern = select(
                label: 'Choose Generator Pattern?',
                options: $patterns,
                default: $patterns[0] ?? null,
                hint: 'Select pattern for blue print generator'
            );
        }

        $source = $this->__published_at = $published_at = $config['patterns'][$pattern]['published_at'];
        $this->__replacements['LOCAL_PATH'] = Str::replace(base_path().'/','',$published_at);
        $this->__at_source = $source .= '/'.$this->__class_basename.'/src';

        //GENERATE MODULE FOLDER
        $this->makeDir($published_at);
        $this->__generator_lists = $config['patterns'][$pattern]['generates'];
        foreach ($this->__generator_lists as $key => $generator) {
            if ($generator['generate']){
                if ($generator['type'] == 'dir'){
                    $this->__relative_path = $this->makeDir($source.DIRECTORY_SEPARATOR.$generator['path']);
                    $this->__libs[$key] = $generator['path'];
                }
            }
        }
        $this->__replacements['LIBS'] = $this->__libs;
        foreach ($this->__generator_lists as $key => $generator) {
            $filename = $generator['filename'] ?? $key;
            if ($generator['generate']){
                if ($generator['type'] == 'dir'){
                    if (isset($generator['files']) && count($generator['files']) > 0){
                        foreach ($generator['files'] as $key_file => $file) {
                            $file['type'] = 'file';
                            $file['path'] = $generator['path'];
                            $filename = $file['filename'] ?? $key_file;
                            $this->generateFile($filename,$file);
                        }
                    }
                }else{
                    //FOR FILE
                    $this->generateFile($filename,$generator);
                }

            }
        }
        return $this;
    }
    
    protected function generateFile(string $filename, array $generator): self{
        $this->cardLine('Generating '.$filename,function() use ($generator,$filename){
            preg_match_all('/' . $this->__open . '(.*?)' . $this->__close . '/', $filename, $matches);
            foreach ($matches[0] as $key => $match) {
                if (!isset($this->__replacements[$matches[1][$key]])) {
                    throw new \Exception('Token ' . $matches[1][$key] . ' not found');
                }
                $filename = Str::replace($match, $this->__replacements[$matches[1][$key]], $filename);
            }
            $ext = Str::replace('.stub','', $generator['stub']);
            if (preg_match('/^\.[a-zA-Z]/', $ext)) {
                $ext = ''; // Dotfile: nggak tambahin ekstensi
            } else {
                $ext = '.'.Str::afterLast($ext, '.');
            }
            Stub::init(generator_stub_path($generator['stub']),$this->__replacements)
                ->saveTo($this->getPackageSource($generator['path']).'/',$filename.$ext);
        });
        return $this;
    }

    protected function resolveToken(string $token): string{
        $value = $this->__replacements[$token] ?? null;

        if (is_callable($value)) {
            return call_user_func($value);
        }

        return $value ?? $this->__open . $token . $this->__close;
    }
}