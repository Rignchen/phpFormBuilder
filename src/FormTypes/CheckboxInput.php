<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class CheckboxInput implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $text,
        private readonly string $class = '',
        private readonly string $textClass = '',
        private $callable = null
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
    public function call($value, callable $callable) {
        if ($this->callable) {
            return $callable($value);
        }
    }

    public function render($value): string {
        $checked = $value===null ? '' : 'checked';
        return "<input type='checkbox' name='$this->name' class='$this->class' id='$this->id' value='' $checked>
                <label for='$this->name' class='$this->textClass'>$this->text</label>";
    }
}