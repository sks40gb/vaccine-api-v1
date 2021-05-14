<?php

namespace Ziletech\Database\DTO;

class CalulateWithdrawFundRequestDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var integer
     */
    public $withdrawMethodId;
    public $amount;
    public $charge;
    public $totalAmount;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $details;

    function getUserId() {
        return $this->userId;
    }

    function getWithdrawMethodId() {
        return $this->withdrawMethodId;
    }

    function getAmount() {
        return $this->amount;
    }

    function getCharge() {
        return $this->charge;
    }

    function getTotalAmount() {
        return $this->totalAmount;
    }

    function getMessage() {
        return $this->message;
    }

    function getDetails() {
        return $this->details;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setWithdrawMethodId($withdrawMethodId) {
        $this->withdrawMethodId = $withdrawMethodId;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setDetails($details) {
        $this->details = $details;
    }

}
