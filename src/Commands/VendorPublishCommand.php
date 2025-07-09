<?php

namespace Hanafalah\LaravelPackageGenerator\Commands;

use Hanafalah\LaravelPackageGenerator\Concerns\HasGenerator;
use Hanafalah\LaravelSupport\Commands\BaseCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Laravel\Prompts\multiselect;

class VendorPublishCommand extends BaseCommand
{
    use HasGenerator;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'generator:publish
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';

    /**
     * The console command description.
     */
    protected $description = 'Command ini digunakan untuk mengenerate package baru berdasarkan pattern';
    protected $files;

    public function handle(): void
    {
        $this->useForPublish();
    }

    protected function useForPublish(?array $supports = null, ?array $config = null){
        if (!isset($config)){
            $this->__pattern = $this->option('pattern') ?? 'repository';
            $this->choosePattern();
            $config = $this->__config_basename;
            $supports = multiselect(
                label: "Select the tag to publish",
                options: ['config', 'stubs', 'migrations', 'data']
            );
    
            $this->info("Publishing the ".implode(', ',$supports)." tag...");
            
            $this->useForPublish($supports,$config);
        }else{
            $this->__pattern = null;
            $this->__class_basename = null;
            $this->__pattern_exceptions = ['repository'];
            $this->choosePattern();
            $target_config = $this->__config_basename;
            foreach ($supports as $support) {
                $values = $config['group_publishes'][$support] ?? [];
                if (isset($values) && count($values) > 0){
                    $config_support = Str::singular($support);
                    foreach ($values as $key => $value) {
                        $filename = Str::afterLast($value, '/');
                        $target_path = Str::replace('\\','/',$target_config['paths']['base_path']);
                        File::copy($key, $target_path.$target_config['libs'][$config_support].'/'.$filename);
                        dump($key, $target_path.$target_config['libs'][$config_support].'/'.$filename);
                    }
                }
            }
            return $this;
        }
    }
}
