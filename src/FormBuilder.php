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
        $this->fields[$name] = $temp;
        return $this->try_call($name, $temp);
    }
    }

