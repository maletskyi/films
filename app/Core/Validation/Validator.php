<?php

namespace App\Core\Validation;

use App\Core\Validation\Rules\RuleInterface;

class Validator
{
    protected $rules = [];

    protected $validationResult = [];

    public function getValidationResult(): array
    {
        return $this->validationResult;
    }

    public function addRule(string $field, RuleInterface $rule)
    {
        $this->rules[$field][] = $rule;

        return $this;
    }

    public function validate(): bool
    {
        $result    = [];
        $hasErrors = false;

        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                if ( ! isset($result[$field]['old'])) {
                    $result[$field]['old'] = $rule->getValue();
                }

                if ( ! $rule->checkRule()) {
                    $result[$field]['old']             = $rule->getValue();
                    $result[$field]['errorMessages'][] = $rule->getErrorMessage();
                    $hasErrors                         = true;
                }
            }
        }

        if ($hasErrors) {
            $this->validationResult = $result;

            return false;
        }

        return true;
    }
}