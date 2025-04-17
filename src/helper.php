<?php 

if (!function_exists('template_base_path')) {
    function template_base_path(?string $path = null) {
        return base_path(config('laravel-package-generator.template_path','') . ($path ? '/' . $path : ''));
    }
}