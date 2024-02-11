<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class RadioInput implements FormType {
    private string $id;
    private int $priority = 2;
    private int $index = -1;

    /**
     * @param array<string> $values
     */
    public function __construct(
        private readonly string $name,
        private readonly array $values,
        private readonly string $value = '',
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
        return $this->id . '-' . $this->index;
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
        $this->index = ($this->index + 1) % count($this->values);
        if ($value === null) $value = $this->value;
        $currentValue = $this->values[$this->index];
        return "<input type='radio'  name='$this->name' class='$this->class' id='{$this->getId()}' value='$currentValue'"
            . ($currentValue === $value ? ' checked' : '') . ">";
    }
}