<?php

namespace Rignchen\Forms;

interface FormType
{
    public function __construct(string $name, string $class = '', $callable = null);
    public function getName(): string;
    public function call($value);
    public function render(): string;
}
