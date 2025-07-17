<?php

namespace Hanafalah\LaravelPackageGenerator\Concerns;

use Hanafalah\LaravelPackageGenerator\Concerns\GeneratorPath;
use Hanafalah\LaravelStub\Facades\Stub;
use Illuminate\Support\Str;

use function Laravel\Prompts\{
    select, text

};

trait HasGenerator{
    use PromptLayout;
    use GeneratorPath;

    protected array $__stub;
    protected string $__published_at;
    protected string $__base_stub;
    protected ?string $__at_source, $__relative_path, $__pattern = null;
    protected string $__open, $__close, $__render;
    protected ?array $__generator_lists, $__config_generator, $__config_basename, $__replacements = [], $__pattern_exceptions = [];
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
        return $this->__published_at.DIRECTORY_SEPARATOR.$this->__snake_class_basename.DIRECTORY_SEPARATOR.'src/'.$path;
    }

    protected function getBaseStub(): string{
        return $this->__base_stub;
    }

    public function initGenerator():self{
        $this->readPackageBasename()
             ->initialConfig()
             ->initiateStub()
             ->setLibs();
        if ($this->getDefinition()->hasOption('package-author')) $this->initiateAuthor();
        $this->initiateReplacement();
        return $this;
    }

    protected function setFirstNamespace(string $first_namespace): self{
        $this->__first_namespace = $first_namespace;
        $this->__replacements['FIRST_NAMESPACE'] = $this->__first_namespace;
        return $this;
    }

    protected function setNamespace(? string $namespace = null): self{
        $this->__namespace = $namespace ?? $this->__first_namespace.'\\'.$this->__class_basename;
        $this->__replacements['NAMESPACE'] = $this->__namespace;
        return $this;
    }

    protected function readPackageBasename(): self{
        if ($this->getDefinition()->hasArgument('namespace')){
            $this->__namespace = Str::replace('/','\\',$this->argument('namespace'));
        }
        if ($this->getDefinition()->hasOption('class-basename')) {
            $this->__class_basename = $this->option('class-basename') ?? Str::afterLast($this->__namespace,'\\');
        }else{
            $this->__class_basename = Str::afterLast($this->__namespace,'\\');
        }
        $class_basename = $this->__class_basename;
        $this->__snake_class_basename       = Str::snake($class_basename,'-');
        $this->__snake_lower_class_basename = Str::snake($class_basename);
        $this->__replacements['NAMESPACE']  = $this->__namespace;
        $namespaces = explode('\\',$this->__namespace);
        foreach ($namespaces as $key => &$namespace) {
            if ($key == 0) $this->__first_namespace = $namespace;
            $namespace = Str::snake($namespace,'-');
        }
        $this->__replacements['FIRST_NAMESPACE']            = $this->__first_namespace;
        $this->__replacements['SNAKE_NAMESPACE']            = implode('/',$namespaces);
        $this->__replacements['CLASS_BASENAME']             = $class_basename;
        $this->__replacements['LOWER_CLASS_BASENAME']       = Str::lower($class_basename);
        $this->__replacements['SNAKE_LOWER_CLASS_BASENAME'] = $this->__snake_lower_class_basename;
        $this->__replacements['SNAKE_CLASS_BASENAME']       = $this->__snake_class_basename;
        return $this;
    }

    protected function initialConfig(): self{
        $this->__config_generator = config('laravel-package-generator');
        return $this;
    }

    protected function initiateStub(): self{
        $this->__stub      = config('laravel-stub.stub');
        $this->__open      = preg_quote($this->__stub['open_separator'], '/');
        $this->__close     = preg_quote($this->__stub['close_separator'], '/');
        $this->__base_stub = generator_stub_path();
        
        return $this;
    }


    protected function initiateAuthor(): self
    {
        $this->__author_name = $this->option('package-author') 
            ?? text(
                label: 'Tolong isi nama author:',
                placeholder: 'Contoh: Hamzah',
                required: true
            );
    
        $this->__author_email = $this->option('package-email') 
            ?? text(
                label: 'Tolong isi email author:',
                placeholder: 'Contoh: hamzah@email.com',
                required: true
            );
    
        $this->info("Author: {$this->__author_name} ({$this->__author_email})");
    
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

    protected function scanListByPattern(string $pattern): array{
        $published_at = $this->__published_at;
        $base_names = array_map(function($path){
            return basename($path);
        },glob($published_at.DIRECTORY_SEPARATOR.'*',GLOB_ONLYDIR));
        return $base_names;
    }

    protected function chooseClassBasename(string $pattern): self{
        $base_names = $this->scanListByPattern($pattern);
        $this->__class_basename = $class_basename = $this->option('class-basename') ?? Str::studly(select(
            label: 'Choose Class Basename?',
            options: $base_names,
            default: $base_names[0] ?? null,
            hint: 'Select class basename for blue print generator'
        ));
        $this->__replacements['CLASS_BASENAME'] = $class_basename;
        $this->__config_basename = $config_basename = config(Str::snake($class_basename,'-'));
        if (!isset($config_basename)) {
            $module_path = base_path($this->__config_generator['patterns'][$this->__pattern]['published_at']).DIRECTORY_SEPARATOR.Str::kebab($this->__class_basename);
            $configFilePath = null;
            $directory = new \RecursiveDirectoryIterator($module_path);
            foreach (new \RecursiveIteratorIterator($directory) as $file) {
                if ($file->getFilename() === 'config.php' && strpos($file->getPath(), 'vendor') === false) {
                    $configFilePath = $file->getPathname();
                    break;
                }
            }

            if ($configFilePath) {
                // Process the config.php file
                $this->__config_basename = $config_basename = include $configFilePath;
            } else {
                throw new \Exception('Config '.$config_basename.' not found');
            }
        }
        $this->setFirstNamespace(explode('\\',$config_basename['namespace'])[0]);
        $this->setNamespace();
        return $this;
    }

    protected function getPublishedAtByPattern(string $pattern): string{
        $source = $this->__published_at = $published_at = base_path($this->__config_generator['patterns'][$pattern]['published_at']);
        $this->__replacements['LOCAL_PATH'] = Str::replace(base_path().'/','',$published_at);
        return $source;
    }

    protected function choosePattern(): self{
        $this->initialConfig();
        $pattern  = $this->option('pattern') ?? $this->__pattern ?? null;
        if (!isset($pattern)){
            $patterns = array_keys($this->__config_generator['patterns']);
            if (count($this->__pattern_exceptions) > 0){
                $patterns = array_values(array_diff($patterns,$this->__pattern_exceptions));
            }
            $pattern = select(
                label: 'Choose Generator Pattern?',
                options: $patterns,
                default: $patterns[0] ?? null,
                hint: 'Select pattern for blue print generator'
            );
        }
        $this->__pattern = $pattern;
        $source = $this->getPublishedAtByPattern($pattern);
        if (!isset($this->__class_basename)) {
            $this->chooseClassBasename($pattern);
        }
        $this->__snake_class_basename = Str::snake($this->__class_basename,'-');
        $this->__at_source = $source .= '/'.$this->__snake_class_basename.'/src';
        return $this;
    }

    protected function setLibs(?array $libs = null): self{
        if (isset($libs)){
            $this->__libs = $libs;
        }else{
            if (isset($this->__pattern)){
                $this->__generator_lists = $this->__config_generator['patterns'][$this->__pattern]['generates'];
                foreach ($this->__generator_lists as $key => $generator) {
                    if ($generator['generate']){
                        if ($generator['type'] == 'dir'){
                            $this->__relative_path = $this->makeDir($this->__at_source.DIRECTORY_SEPARATOR.$generator['path']);
                            $this->__libs[$key] = $generator['path'];
                        }
                    }
                }
            }
        }
        return $this;
    }

    protected function initiateLibsReplacement(): self{
        $this->__replacements['LIBS'] = $this->__libs;
        $this->__replacements['NAMESPACES'] = [];
        foreach ($this->__replacements['LIBS'] as $key => $namespace) {
            $namespaces = explode('/', $namespace);
            foreach ($namespaces as &$namespace) {
                $namespace = Str::studly($namespace);
            }
            $namespace = implode('\\', $namespaces);
            $this->__replacements['NAMESPACES'][$key.'_namespace'] = $namespace;
        }
        return $this;
    }

    protected function generatePattern(): self{
        $this->choosePattern();
        $config       = $this->__config_generator;
        $published_at = $this->__published_at;
        $pattern      = $this->__pattern;
        $source       = $this->__at_source;

        //GENERATE MODULE FOLDER
        $this->makeDir($published_at);
        $this->setLibs();
        $this->initiateLibsReplacement();
        foreach ($this->__generator_lists as $key => $generator) {
            $filename = $generator['filename'] ?? $key;
            if ($generator['generate']){
                if ($generator['type'] == 'dir'){
                    if (isset($generator['files']) && count($generator['files']) > 0){
                        foreach ($generator['files'] as $key_file => $file) {
                            $file['type'] = 'file';
                            $file['path'] = $generator['path'].(isset($file['path']) ? '/'.$file['path'] : '');
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
    
    protected function generateFile(string $filename, array $generator, ?bool $save = true): string{
        $this->cardLine('Generating '.$filename,function() use ($generator,$filename, $save){
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
            $stub = Stub::init(generator_stub_path($generator['stub']),$this->__replacements);
            $this->__render = $stub->render();
            if ($save) $stub->saveTo($this->getPackageSource($generator['path']).'/',$filename.$ext);
        });
        return $this->__render;
    }

    protected function resolveToken(string $token): string{
        $value = $this->__replacements[$token] ?? null;

        if (is_callable($value)) {
            return call_user_func($value);
        }

        return $value ?? $this->__open . $token . $this->__close;
    }
}