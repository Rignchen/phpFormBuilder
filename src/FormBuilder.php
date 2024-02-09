<?php

namespace Rignchen\Forms;

class FormBuilder {
    /**
     * @var array<FormType> $fields
     */
    private array $fields = [];
    private bool $is_rendered = false;
	
    public function __construct(
        private readonly string $method = 'get',
        private readonly string $action = '',
        private readonly string $class = ''
    ) {
        if (!in_array($method, ['get', 'post'])) {
            throw new \InvalidArgumentException('Invalid action');
        }
    }

    public function add(FormType $type): void {
        if ($this->is_rendered) {
            throw new \RuntimeException('Form is already rendered');
        }
        $temp = $type;
        $name = $temp->getName();
        if (isset($this->fields[$name])) {
            throw new \InvalidArgumentException('Field already exists');
        }
        $temp->setID($name . "-" . count($this->fields));
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

    private function try_call(): void {
        $data = [];
        if ($this->method === 'get') {
            $data = $_GET;
        } elseif ($this->method === 'post') {
            $data = $_POST;
        }
        foreach ($this->fields as $name => $field) {
            if (isset($data[$name])) {
                $field->call($data[$name], $field->getCallable());
            }
        }
    }
}

