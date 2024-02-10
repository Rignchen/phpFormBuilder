<?php

namespace Rignchen\Forms\FormTypes;
use Exception;
use Rignchen\Forms\FormType;

class PasswordInput implements FormType {
    private string $id;
    private int $priority = 1;
    
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
        if (isset($_SESSION['Rignchen']['Forms']['safePost']['data'][$name])) unset($_SESSION['Rignchen']['Forms']['safePost']['data'][$name]);
    }

    public function getPriorityLevel(): int {
        return $this->priority;
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
        return "<input type='password' name='$this->name' class='$this->class' id='$this->id'>";
    }
}