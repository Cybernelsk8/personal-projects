<?php
namespace Core\Validation\Exceptions;

use Core\Exceptions\MuniException;

class ValidationException extends MuniException {
    public function __construct(protected array $errors) {
        $this->errors = $errors;
    }

    public function errors(): array {
        return $this->errors;
    }
}
