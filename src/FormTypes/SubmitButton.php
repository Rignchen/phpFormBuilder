<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class SubmitButton implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private readonly string $text = 'Submit',
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
    public function call($value, callable $callable): void {
        $callable($value);
    }

    public function render($value): string {
        return "<input type='submit' class='$this->class' name='$this->name' id='$this->id' value='$this->text'>";
    }
}