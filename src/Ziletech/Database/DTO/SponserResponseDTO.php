<?php

namespace Ziletech\Database\DTO;

class SponserResponseDTO extends BaseDTO {

    public $userId;
    public $name;

    function getUserId() {
        return $this->userId;
    }

    function getName() {
        return $this->name;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setName($name) {
        $this->name = $name;
    }

}
