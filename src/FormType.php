<?php

namespace Rignchen\Forms;

interface FormType
{
    public function getName(): string;
    public function getCallable(): callable;
    public function call($value, callable $callable);
    public function render($value): string;
}
