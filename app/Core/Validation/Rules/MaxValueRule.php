<?php

namespace App\Core\Validation\Rules;


class MaxValueRule extends AbstractRule
{
    private $maxValue;

    public function __construct($minValue, $value, $errorMessage)
    {
        parent::__construct($value, $errorMessage);

        $this->maxValue = $minValue;
    }

    public function checkRule(): bool
    {
        return $this->value <= $this->maxValue;
    }
}