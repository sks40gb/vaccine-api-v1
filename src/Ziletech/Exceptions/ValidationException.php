<?php

namespace Ziletech\Exceptions;

class ValidationException extends \Exception {

    private $errors;

    // Redefine the exception so message isn't optional
    public function __construct($errors, $code = 0, Exception $previous = null) {
        $this->errors = $errors;
        parent::__construct("Validation Error", $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function getErrors() {
        return $this->errors;
    }

}
