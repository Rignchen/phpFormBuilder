<?php

namespace src;

class FormBuilder {
    private string $action;
    private string $method;
    private string $class;
    public function __construct(string $action = 'get', string $method = '', string $class = '') {
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }
    }

