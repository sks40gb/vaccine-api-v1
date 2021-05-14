<?php

namespace Ziletech\Exceptions;

class ZiletechException extends \Exception {

    // Redefine the exception so message isn't optional
    public function __construct($error, $code = 0, Exception $previous = null) {
        parent::__construct($error, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
