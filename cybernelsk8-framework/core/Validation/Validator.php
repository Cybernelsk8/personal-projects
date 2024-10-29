<?php

namespace Core\Validation;

use Core\Validation\Exceptions\ValidationException;
use Core\Validation\Rule;

class Validator {
    protected array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function validate(array $validationRules, array $messages = []): array {
        $validated = [];
        $errors = [];
        foreach ($validationRules as $field => $rules) {

            if(!strpos($rules,"|")){
                $rules = [$rules];
            }else{
                $rules = explode("|",$rules);
            }
            
            $fieldUnderValidationErrors = [];
            foreach ($rules as $rule) {
                if (is_string($rule)) {
                    $rule = Rule::from($rule);
                }
                if (!$rule->isValid($field, $this->data)) {
                    $message = $messages[$field][Rule::nameOf($rule)] ?? $rule->message();
                    $fieldUnderValidationErrors[Rule::nameOf($rule)] = $message;
                }
            }
            if (count($fieldUnderValidationErrors) > 0) {
                $errors[$field] = $fieldUnderValidationErrors;
            } else {
                $validated[$field] = $this->data[$field] ?? null;
            }
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        return $validated;
    }
}