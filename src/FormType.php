<?php

namespace Rignchen\Forms;

interface FormType
{
    public function getName(): string;
    public function call($value);
    public function render(): string;
}
