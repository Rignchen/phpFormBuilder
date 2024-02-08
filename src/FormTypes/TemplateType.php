<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TemplateType implements FormType {

    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getCallable(): callable {
        return $this->callable ?? fn($value) => $value;
    }
    public function call($value, $callable)
    {
        if ($this->callable) {
            return $callable($value);
        }
    }

    public function render($value): string
    {
        // TODO: Implement render() method.
    }
}