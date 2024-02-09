<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class TextArea implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private readonly string $value = '',
        private readonly int|null $cols = null,
        private readonly int|null $rows = null,
        private readonly string $placeholder = ""
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
        return "<textarea name='$this->name' class='$this->class' id='$this->id' placeholder='$this->placeholder'"
            . ($this->cols !== null ? " cols='$this->cols'" : '')
            . ($this->rows !== null ? " rows='$this->rows'" : '')
            . ">$value</textarea>";
    }
}