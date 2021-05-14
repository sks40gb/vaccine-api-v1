<?php

namespace Ziletech\Database\DTO;

class OpenSupportMessageRequestDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $subject;

    function getUserId() {
        return $this->userId;
    }

    function getMessage() {
        return $this->message;
    }

    function getSubject() {
        return $this->subject;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

}
