<?php

namespace Hanafalah\LaravelPackageGenerator\Supports;

use Illuminate\Container\Container;
use Hanafalah\LaravelPackageGenerator\Concerns\JsonGenerator;
use Hanafalah\LaravelPackageGenerator\FileRepository;

class Generator extends FileRepository
{
    use JsonGenerator;

    public function __construct(Container $app, ...$args)
    {
        parent::__construct($app, ...$args);
        $this->__json = [];
        $this->__json_template = $this->parse($this->getContent(__DIR__ . '/../versioning.json'));
    }
}
