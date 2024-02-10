<?php

namespace Rignchen\Forms\FormTypes;
use JetBrains\PhpStorm\NoReturn;
use Rignchen\Forms\FormType;

class ResetButton implements FormType {
    private string $id;
    public function __construct(
        private readonly string $name,
        private readonly string $class = '',
        private $callable = null,
        private readonly string $value = 'Reset'
    ) {}

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
        return $this->callable ?? fn($value) => $value;
    }
    #[NoReturn] public function call($value, callable $callable): void {
        $callable($value);
        $_SESSION['Rignchen']['Forms']['safePost']['bypassNextCall'] = true;
        $_SESSION['Rignchen']['Forms']['safePost']['data'] = [];
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    public function render($value): string {
        if ($value === null) $value = $this->value;
        return "<input type='submit' name='$this->name' class='$this->class' id='$this->id' value='{$value}'>";
    }
}