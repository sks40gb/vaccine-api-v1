<?php

namespace Ziletech\Database\DTO;

class PlanDashboardDTO extends BaseDTO {

    public $userName;
    public $planName;
    public $price;
    public $userId;
    
    function getUserName() {
        return $this->userName;
    }

    function getPlanName() {
        return $this->planName;
    }

    function getPrice() {
        return $this->price;
    }

    function getUserId() {
        return $this->userId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPlanName($planName) {
        $this->planName = $planName;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

}
