<?php

namespace src;

class FormBuilder {
    private string $action;
    private string $method;
    private string $class;
    private array $fields = [];
    public function __construct(string $action = 'get', string $method = '', string $class = '') {
        if (!in_array($action, ['get', 'post'])) {
            throw new \InvalidArgumentException('Invalid action');
        }
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }

    public function addField(FormType $type) {
        $temp = $type;
        $name = $temp->getName();
        if (isset($this->fields[$name])) {
            throw new \InvalidArgumentException('Field already exists');
        }
        $this->fields[$name] = $temp;
        return $this->try_call($name, $temp);
    }

    public function render(): FormRenderer {
        return new FormRenderer($this->action, $this->method, $this->class, $this->fields);
    }

    private function try_call(string $name, FormType $form_element) {
        if ($this->method === 'post' && isset($_POST[$name])) {
            return $form_element->call($_POST[$name]);
        }
        if ($this->method === 'get' && isset($_GET[$name])) {
            return $form_element->call($_GET[$name]);
        }
    }
}

