<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelPackageGenerator\Facades\LaravelPackageGenerator;
use Hanafalah\LaravelStub\Facades\Stub;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class GeneratePackageCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'generator:add 
        {package-basename : Nama package}
        {--package-author : Nama author}
        {--package-email : Email author}
        {--pattern= : Pattern yang digunakan}';

    /**
     * The console command description.
     */
    protected $description = 'Command ini digunakan untuk mengenerate package baru berdasarkan pattern';

    protected string $__package_name, $__snake_package_name;
    protected array $__stub;
    protected string $__open, $__close;
    protected string $__author_email, $__author_name;
    protected string $__published_at;
    protected array $__generator_lists;

    protected function readPackageBasename(): self{
        $this->__package_name       = $package_name = $this->argument('package-basename');
        $this->__snake_package_name = Str::snake($package_name,'-');
        return $this;
    }

    protected function initiateStub(): self{
        $this->__stub  = config('laravel-stub.stub');
        $this->__open  = preg_quote($this->__stub['open_separator'], '/');
        $this->__close = preg_quote($this->__stub['close_separator'], '/');
        return $this;
    }

    protected function initiateAuthor(): self{
        $this->__author_name  = $this->option('package-author') ?? $this->ask('Add author name :');
        $this->__author_email = $this->option('package-email') ?? $this->ask('Add author email : ');
        return $this;
    }

    private function initiateGenerator(): self{
        $config = config('laravel-package-generator');
        $this->__published_at    = $published_at = $config['published_at'];

        //GENERATE MODULE FOLDER
        LaravelPackageGenerator::generate()
             ->serviceProvider();

        $this->__generator_lists = $config['generate'];
        foreach ($this->__generator_lists as $key => $generator) {
            if ($generator['generate']){
                if (is_dir())
            }
        }
        return $this;
    }

    public function handle(): void
    {
        $this->readPackageBasename()
             ->initiateStub()
             ->initiateAuthor()
             ->initiateGenerator();






        $pattern      = $this->option('pattern') ?? $this->ask('Pattern mana yang ingin anda gunakan?', 'pattern_1');
        if (isset($pattern)){
            $templatePath = template_base_path($pattern);
    
            if (!is_dir($templatePath)) {
                $this->error("Pattern '{$pattern}' tidak ditemukan.");
                return;
            }
    
            // Buat semua folder (termasuk kosong)
            $folders = $this->scanFolderPaths($templatePath);
            dd($folders);
            foreach ($folders as $folder_relative_path) {

                $resolved = $this->replaceTokens($folder_relative_path);
                $destinationDir = $published_at . DIRECTORY_SEPARATOR . $resolved;
    
                if (!is_dir($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                    $this->info("📁 Folder dibuat: {$resolved}");
                }
            }
    
            // Copy semua file
            $files = $this->scanFiles($templatePath);
            foreach ($files as $relativePath => $fullPath) {
                $newRelativePath = $this->replaceTokens($relativePath);
                $destination = $published_at . DIRECTORY_SEPARATOR . $newRelativePath;
    
                $this->line("📄 Copying: {$relativePath} → {$newRelativePath}");
    
                $dir = dirname($destination);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
    
                $content = file_get_contents($fullPath);
                $content = $this->replaceTokens($content);
    
                file_put_contents($destination, $content);
            }
    
            $save_path     = $this->getGenerateLocation().'/'.$choosedConfig['generate']['config']['path'];

        }


        $this->info("✅ Package berhasil digenerate di: {$published_at}");
    }

    protected function scanFiles(string $basePath, string $prefix = ''): array
    {
        $files = [];
        $items = scandir($basePath);

        foreach ($items as $item) {
            if (in_array($item, ['.', '..'])) continue;

            $fullPath = $basePath . DIRECTORY_SEPARATOR . $item;
            $relativePath = ltrim($prefix . DIRECTORY_SEPARATOR . $item, DIRECTORY_SEPARATOR);

            if (is_dir($fullPath)) {
                $files = array_merge($files, $this->scanFiles($fullPath, $relativePath));
            } else {
                $files[$relativePath] = $fullPath;
            }
        }

        return $files;
    }

    protected function scanFolderPaths(string $basePath, string $prefix = ''): array
    {
        $folders = [];
        $items   = scandir($basePath);

        foreach ($items as $item) {
            if (in_array($item, ['.', '..'])) continue;

            $full_path     = $basePath . DIRECTORY_SEPARATOR . $item;
            $relative_path = ltrim($prefix . DIRECTORY_SEPARATOR . $item, DIRECTORY_SEPARATOR);

            // $match_relative_paths = $this->getStubPlaceholders($relative_path);
            // if (count($match_relative_paths) > 0){
            //     foreach ($match_relative_paths as $match_relative_path) {
            //         $relative_path = Str::replace($match_relative_path, $this->__replacements[$match_relative_path], $relative_path);
            //     }
            //     SAMPE SINI YAH ZAH
            //     dd($match_relative_paths);;
            // }
            if (is_dir($full_path)) {
                $folders[] = $relative_path;
                $folders = array_merge($folders, $this->scanFolderPaths($full_path, $relative_path));
            }
        }

        return $folders;
    }

    protected function getStubPlaceholders(string $string): array
    {
        $regex = "/{$this->__open}\s*(.+?)\s*{$this->__close}/";

        preg_match_all($regex, $string, $matches);

        return $matches[1] ?? [];
    }

    protected function replaceTokens(string $content): string{
        foreach ($this->replacements as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }

        return $content;
    }
}
