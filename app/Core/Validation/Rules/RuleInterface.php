<?php

namespace App\Core\Validation\Rules;

interface RuleInterface
{
    public function checkRule(): bool;

    public function getErrorMessage(): string;

    public function getValue();
}