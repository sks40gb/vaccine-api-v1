<?php

namespace Ziletech\Validation;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    /** @var array Validations errors */
    protected $errors = [];

    /**
     * Validate request params based on provided rules and fields
     *
     * @param ServerRequestInterface $request
     * @param array $rules
     *
     * @return static
     * @throws Exception
     */
    public function validate(ServerRequestInterface $request, array $rules): Validator {
        /** @var \Respect\Validation\Validator $rule */
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        $_SESSION['errors'] = $this->errors;


        return $this;
    }

    /**
     * Validate an array of values and fields
     *
     * @param array $values
     * @param array $rules
     *
     * @return static
     * @throws Exception
     */
    public function validateArray(array $values, array $rules): Validator {
        /** @var \Respect\Validation\Validator $rule */
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert($this->getValue($values, $field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        $_SESSION['errors'] = $this->errors;


        return $this;
    }

    /**
     * Check if there is any validation error
     *
     * @return bool
     */
    public function failed(): bool {
        return !empty($this->errors);
    }

    /**
     * Return all validations errors if any
     *
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * get the value of the array
     *
     * @param $values
     * @param $field
     *
     * @return string|null
     */
    private function getValue($values, $field) {
        return isset($values[$field]) ? $values[$field] : null;
    }

}
