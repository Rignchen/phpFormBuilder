<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TextInput implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private string $value = ''
    ) {}

    public function getName(): string {
        return $this->name;
    }
    public function setID(string $id): void {
        $this->id = $id;
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
        return "<input type='text' name='{$this->name}' class='{$this->class}' id='$this->id' value='{$this->value}'>";
    }
}