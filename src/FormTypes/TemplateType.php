<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TemplateType implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private readonly string $value = ''
    ) {}

    public function getName(): string {
        return $this->name;
    }
    public function getID(): string {
        return $this->id;
    }
    public function setID(string $id): void {
        $this->id = $id;
    }

    public function getCallable(): callable {
        return $this->callable ?? fn($value) => $value;
    }
    public function call($value, callable $callable): void {
        $callable($value);
    }

    public function render($value): string {
        if ($value === null) $value = $this->value;
        return "<----- name='$this->name}' class='$this->class' id='$this->id' value='{$value}'>";
    }
}