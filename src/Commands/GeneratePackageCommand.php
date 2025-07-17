<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelPackageGenerator\Concerns\HasGenerator;
use Hanafalah\LaravelSupport\Commands\BaseCommand;

class GeneratePackageCommand extends BaseCommand
{
    use HasGenerator;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'generator:add {namespace}
        {--package-author= : Nama author}
        {--package-email= : Email author}
        {--pattern= : Pattern yang digunakan}';

    /**
     * The console command description.
     */
    protected $description = 'Command ini digunakan untuk mengenerate package baru berdasarkan pattern';

    public function handle(): void
    {
        $this->initGenerator()->generatePattern();
    }
}
