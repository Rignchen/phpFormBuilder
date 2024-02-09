<?php

namespace Rignchen\Forms\FormTypes;
use Exception;
use Rignchen\Forms\FormType;

class PasswordInput implements FormType {
    private string $id;

    /**
     * @throws Exception if $callable is null
     */
    public function __construct(
        private readonly string $name,
        private $callable,
        private readonly string $class = '',
    ) {
        if (isset($_GET[$name])) unset($_GET[$name]);
        if (isset($_POST[$name])) unset($_POST[$name]);
    }

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
        return $this->callable;
    }
    public function call($value, callable $callable): void {
        $callable($value);
    }

    public function render($value): string {
        return "<input type='password' name='{$this->name}' class='{$this->class}' id='$this->id'>";
    }
}