<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TextInput implements FormType {
    private string $name;
    private string $class;
    private $callable;
    private string $value;

    public function __construct(string $name, string $class = '', $callable = null, string $value = '') {
        $this->name = $name;
        $this->class = $class;
        $this->callable = $callable;
        $this->value = $value;
    }

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