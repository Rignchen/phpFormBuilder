<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TextInput implements FormType {
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private string $value = ''
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getCallable(): callable {
        return $this->callable ?? fn($value) => $value;
    }
    public function call($value, callable $callable) {
        if ($this->callable) {
            return $callable($value);
        }
    }

    public function render($value): string {
        if ($value !== null) $this->value = $value;
        return "<input type='text' name='{$this->name}' class='{$this->class}' value='{$this->value}'>";
    }
}