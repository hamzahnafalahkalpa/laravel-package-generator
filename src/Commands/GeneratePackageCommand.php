<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelPackageGenerator\Concerns\HasGenerator;
use Illuminate\Console\Command;

class GeneratePackageCommand extends Command
{
    use HasGenerator;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'generator:add 
        {namespace : Namespace Package ex: Hanafalah\\LaravelPackageGenerator}
        {--package-author= : Nama author}
        {--package-email= : Email author}
        {--pattern= : Pattern yang digunakan}';

    /**
     * The console command description.
     */
    protected $description = 'Command ini digunakan untuk mengenerate package baru berdasarkan pattern';

    public function handle(): void
    {
        $this->init()->generate();
    }
}
