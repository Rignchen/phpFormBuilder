<?php

namespace src;

class FormRenderer
{
    private string $action;
    private string $method;
    private string $class;
    private array $fields;
    private bool $is_open = false;

    public function __construct(string $action, string $method, string $class, array $fields) {
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
        $this->fields = $fields;
    }

    public function open(): string {
        if ($this->is_open) {
            throw new \InvalidArgumentException('Form is already open');
        }
        $this->is_open = true;
        return "<form action='{$this->action}' method='{$this->method}' class='{$this->class}'>";
    }


    public function get(string $name): string {
        if (!$this->is_open) {
            throw new \InvalidArgumentException('Form is not open');
        }
        if (isset($this->fields[$name])) {
            return $this->fields[$name]->render();
        }
        throw new \InvalidArgumentException('Field does not exist');
    }
}