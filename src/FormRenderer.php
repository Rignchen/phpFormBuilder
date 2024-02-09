<?php

namespace Rignchen\Forms;

class FormRenderer
{
    private bool $is_open = false;
    private bool $is_closed = false;

    /**
     * @param string $action
     * @param string $method
     * @param string $class
     * @var array<FormType> $fields
     */
    public function __construct(
        private readonly string $action,
        private readonly string $method,
        private readonly string $class,
        private readonly array $fields,
        private readonly array $data
    ) {}

    public function open(): string {
        if ($this->is_open) {
            throw new \InvalidArgumentException('Form is already open');
        }
        $this->is_open = true;
        return "<form action='$this->action' method='$this->method' class='$this->class'>";
    }

    public function close(): string {
        if (!$this->is_open) {
            throw new \InvalidArgumentException('Form is not open');
        }
        if ($this->is_closed) {
            throw new \InvalidArgumentException('Form is already closed');
        }
        $this->is_closed = true;
        return '</form>';
    }

    public function label(string $for, string $value, string $class = ''): string {
        $id = $this->fields[$for]->getID();
        return "<label for='$id' class='$class'>$value</label>";
    }
    public function get(string $name): string {
        if (!$this->is_open) {
            throw new \InvalidArgumentException('Form is not open');
        }
        if ($this->is_closed) {
            throw new \InvalidArgumentException('Form is closed');
        }
        if (isset($this->fields[$name]))
            return $this->fields[$name]->render($this->data[$name] ?? null);
        throw new \InvalidArgumentException('Field does not exist');
    }
}