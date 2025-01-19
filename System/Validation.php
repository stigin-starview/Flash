<?php

namespace learnspace\flash\System;

class Validation
{
    private array $errors = [];

    public function validate(array $data, string $ruleSet): bool
    {
        // Fetch the predefined rules
        $rules = $this->getRules($ruleSet);

        foreach ($rules as $field => $conditions) {
            foreach (explode('|', $conditions) as $condition) {
                if (!$this->applyCondition($field, $data[$field] ?? null, $condition)) {
                    $this->errors[$field][] = $this->getErrorMessage($field, $condition);
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function getRules(string $ruleSet): array
    {
        // Modify each rules to your requirements
        // Each rule should be called with validation.
        $ruleDefinitions = [
            'stringValid' => [
                'content' => 'required|string|min:5|max:500',
            ],
            'userRegistration' => [
                'username' => 'required|string|min:3|max:20',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ],
            // Add more rules here
        ];

        return $ruleDefinitions[$ruleSet] ?? [];
    }

    private function applyCondition(string $field, $value, string $condition): bool
    {
        [$rule, $parameter] = explode(':', $condition . ':');
        switch ($rule) {
            case 'required':
                return !empty($value);
            case 'string':
                return is_string($value);
            case 'min':
                return strlen((string)$value) >= (int)$parameter;
            case 'max':
                return strlen((string)$value) <= (int)$parameter;
            default:
                return true;
        }
    }

    private function getErrorMessage(string $field, string $condition): string
    {
        [$rule, $parameter] = explode(':', $condition . ':');
        $messages = [
            'required' => "The $field field is required.",
            'string' => "The $field field must be a string.",
            'min' => "The $field field must be at least $parameter characters long.",
            'max' => "The $field field must be no more than $parameter characters long.",
        ];

        return $messages[$rule] ?? "Invalid value for $field.";
    }
}
