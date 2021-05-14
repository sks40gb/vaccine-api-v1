<?php

namespace Ziletech\Database\DTO;


class SmsRequestDTO extends BaseDTO {

    public $message;
    public $sender;
    
    
    public $numbers;

    public function __construct() {
        
    }

    function getMessage() {
        return $this->message;
    }

    function getSender() {
        return $this->sender;
    }

    function getNumbers() {
        return $this->numbers;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setSender($sender) {
        $this->sender = $sender;
    }

    function setNumbers($numbers) {
        $this->numbers = $numbers;
    }



}
