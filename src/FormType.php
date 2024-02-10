<?php

namespace Rignchen\Forms;

interface FormType
{
    /** 0 = important to generate first<br> 1 = generate before the usual<br> 2 = usual<br> 3 = generate after the usual<br> 4 = important to generate last<br> */
    public function getPriorityLevel(): int;
    public function getName(): string;
    public function getCallable(): callable;
    public function call($value, callable $callable): void;
    public function render($value): string;
    public function setID(string $id);
    public function getID(): string;
}
