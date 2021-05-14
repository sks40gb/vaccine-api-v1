<?php

namespace Ziletech\Database\DTO;

class ManageSubAccountRequestDTO extends BaseDTO {

    public $planId;
    public $userName;
    public $underUserName;
    public $ownerId;

    function getPlanId() {
        return $this->planId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getUnderUserName() {
        return $this->underUserName;
    }

    function getOwnerId() {
        return $this->ownerId;
    }

    function setPlanId($planId) {
        $this->planId = $planId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setUnderUserName($underUserName) {
        $this->underUserName = $underUserName;
    }

    function setOwnerId($ownerId) {
        $this->ownerId = $ownerId;
    }

}
