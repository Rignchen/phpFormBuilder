<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class CheckboxInput implements FormType {
    private string $id;
    private int $priority = 2;
    
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null
    ) {}

    public function getPriorityLevel(): int {
        return $this->priority;
    }
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
        $checked = $value===null ? '' : 'checked';
        return "<input type='checkbox' name='$this->name' class='$this->class' id='$this->id' value='' $checked>";
    }
}