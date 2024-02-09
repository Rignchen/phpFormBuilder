<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class NumberInput implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private readonly int|null $min = null,
        private readonly int|null $max = null,
        private readonly int|null $step = null,
        private string $value = ''
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
        if (!$this->is_valid($value)) throw new \InvalidArgumentException('Invalid value');
        $callable(intval($value));
    }

    public function render($value): string {
        if ($this->is_valid($value)) $this->value = $value;
        return "<input type='number' name='{$this->name}' class='{$this->class}' id='$this->id' value='{$this->value}'"
            . ($this->min ? " min='{$this->min}'" : '')
            . ($this->max ? " max='{$this->max}'" : '')
            . ($this->step ? " step='{$this->step}'" : '')
            . '>';
    }

    private function is_valid($value): bool {
        return $value !== ''
            && is_numeric($value)
            && ($this->min === null || $value >= $this->min)
            && ($this->max === null || $value <= $this->max)
            && ($this->step === null || $value % $this->step === 0);
    }
}