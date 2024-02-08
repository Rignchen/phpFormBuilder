<?php

namespace src;

class FormRenderer
{
    private string $action;
    private string $method;
    private string $class;
    private array $fields;

    public function __construct(string $action, string $method, string $class, array $fields) {
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
        $this->fields = $fields;
    }

    public function get(string $name): string {
        if (isset($this->fields[$name])) {
            return $this->fields[$name]->render();
        }
        throw new \InvalidArgumentException('Field does not exist');
    }
}