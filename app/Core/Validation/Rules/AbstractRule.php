<?php

namespace App\Core\Validation\Rules;

abstract class AbstractRule implements RuleInterface
{
    protected $value;
    protected $errorMessage;

    public function __construct($value, $errorMessage)
    {
        $this->value = $value;
        $this->errorMessage= $errorMessage;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}