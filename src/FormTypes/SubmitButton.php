<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class SubmitButton implements FormType {
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private readonly string $text = 'Submit',
        private $callable = null
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getCallable(): callable {
        return $this->callable ?? fn($value) => $value;
    }
    public function call($value, $callable) {
        if ($this->callable) {
            return $callable($value);
        }
    }

    public function render($value): string {
        return "<input type='submit' class='$this->class' name='$this->name' value='$this->text'>";
    }
}