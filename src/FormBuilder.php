<?php

namespace Rignchen\Forms;

class FormBuilder {
    private string $action;
    private string $method;
    private string $class;
    private array $fields = [];
    private bool $is_rendered = false;
    public function __construct(string $method = 'get', string $action = '', string $class = '') {
        if (!in_array($method, ['get', 'post'])) {
            throw new \InvalidArgumentException('Invalid action');
        }
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }

    public function add(FormType $type) {
        if ($this->is_rendered) {
            throw new \RuntimeException('Form is already rendered');
        }
        $temp = $type;
        $name = $temp->getName();
        if (isset($this->fields[$name])) {
            throw new \InvalidArgumentException('Field already exists');
        }
        $this->fields[$name] = $temp;
    }

    public function render(): FormRenderer {
        if ($this->is_rendered) {
            throw new \RuntimeException('Form is already rendered');
        }
        $this->try_call();
        $this->is_rendered = true;
        return new FormRenderer($this->action, $this->method, $this->class, $this->fields);
    }

    private function try_call() {
        $data = [];
        if ($this->method === 'get') {
            $data = $_GET;
        } elseif ($this->method === 'post') {
            $data = $_POST;
        }
        foreach ($this->fields as $name => $field) {
            if (isset($data[$name])) {
                $field->setValue($data[$name]);
            }
        }
    }
}

