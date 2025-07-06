<?php 

if (!function_exists('generator_stub_path')) {
    function generator_stub_path(?string $path = null) {
        return config('laravel-package-generator.stub.path').($path ? '/' . $path : '');
    }
}

if (!function_exists('template_base_path')) {
    function template_base_path(?string $path = null) {
        return base_path(config('laravel-package-generator.template_path','')).($path ? '/' . $path : '');
    }
}