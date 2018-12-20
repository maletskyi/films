<?php

namespace App\Core\Validation\Rules;

class RegexRule extends AbstractRule
{
    private $regex;

    public function __construct($regex, $value, $errorMessage)
    {
        parent::__construct($value, $errorMessage);

        $this->regex = $regex;
    }

    public function checkRule(): bool
    {
        return (bool) preg_match($this->regex, $this->value);
    }
}