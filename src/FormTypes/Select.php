<?php

namespace Rignchen\Forms\FormTypes;
use Rignchen\Forms\FormType;

class Select implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly array $options,
        private readonly int $default = 0,
        private readonly string $class = '',
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
    public function call($value, $callable) {
        return $callable($value);
    }

    public function render($value): string {
        if ($value === null || $value < 0 || $value >= count($this->options))
            $value = $this->default;
        $output = "<select name='{$this->name}' class='{$this->class}' id='$this->id'>";
        foreach ($this->options as $key => $option) {
            $output .= "<option value='$key' " . ($value == $key ? 'selected' : '') . ">" . $this->call($option, $this->getCallable()) . "</option>";
        }
        return $output . '</select>';
    }
}