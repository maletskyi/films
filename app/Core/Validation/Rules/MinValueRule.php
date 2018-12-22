<?php

namespace App\Core\Validation\Rules;


class MinValueRule extends AbstractRule
{
    private $minValue;

    public function __construct($minValue, $value, $errorMessage)
    {
        parent::__construct($value, $errorMessage);

        $this->minValue = $minValue;
    }

    public function checkRule(): bool
    {
        return $this->value >= $this->minValue;
    }
}