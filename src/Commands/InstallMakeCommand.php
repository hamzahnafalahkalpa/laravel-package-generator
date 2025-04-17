<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

class InstallMakeCommand extends EnvironmentCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:install';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command ini digunakan untuk installing awal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = 'Hanafalah\LaravelPackageGenerator\LaravelPackageGeneratorServiceProvider';

        $this->comment('Installing Support...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'config'
        ]);
        $this->info('✔️  Created config/laravel-package-generator.php');

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'stubs'
        ]);
        $this->info('✔️  Created Stubs/LaravelPackageGeneratorStubs');

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'providers'
        ]);

        $this->info('✔️  Created LaravelPackageGeneratorServiceProvider.php');

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'migrations'
        ]);

        $this->info('✔️  Created migrations');

        if (!$this->isMultitenancy()) {
            $migrations = $this->canMigrate();

            $this->callSilent('migrate', [
                '--path' => $migrations
            ]);

            $this->info('✔️  App table migrated');
        }


        $this->comment('hanafalah/laravel-package-generator installed successfully.');
    }
}
