<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TemplateType implements FormType {
    private string $name;
    private string $class;
    private $callable;

    public function __construct(string $name, string $class = '', $callable = null) {
        $this->name = $name;
        $this->class = $class;
        $this->callable = $callable;
    }

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