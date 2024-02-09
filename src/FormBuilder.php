<?php

namespace Rignchen\Forms;

class FormBuilder {
    /**
     * @var array<FormType> $fields
     */
    private array $fields = [];
    private bool $is_rendered = false;
    private array $data = [];
	
    public function __construct(
        private readonly string $method = 'get',
        private readonly string $action = '',
        private readonly string $class = ''
    ) {
        if (!in_array($method, ['get', 'post']))
            throw new \InvalidArgumentException('Invalid action');
        if ($this->method === 'get')
            $this->data = $_GET;
        elseif ($this->method === 'post')
            $this->data = $_POST;
    }

    public function add(FormType $type): void {
        if ($this->is_rendered)
            throw new \RuntimeException('Form is already rendered');
        $temp = $type;
        $name = $temp->getName();
        if (isset($this->fields[$name]))
            throw new \InvalidArgumentException('Field already exists');
        $temp->setID($name . "-" . count($this->fields));
        $this->fields[$name] = $temp;
    }

    /**
     * @param array<FormType> $types
     */
    public function addList(array $types): void {
        foreach ($types as $type) $this->add($type);
    }

    public function render(): FormRenderer {
        if ($this->is_rendered)
            throw new \RuntimeException('Form is already rendered');
        $this->try_call();
        $this->is_rendered = true;
        return new FormRenderer($this->action, $this->method, $this->class, $this->fields);
    }

    private function try_call(): void {
        foreach ($this->fields as $name => $field)
            if (isset($this->data[$name]))
                $field->call($this->data[$name], $field->getCallable());
    }
}

