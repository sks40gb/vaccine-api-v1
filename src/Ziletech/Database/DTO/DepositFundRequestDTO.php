<?php

namespace Ziletech\Database\DTO;

class DepositFundRequestDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var integer
     */
    public $paymentMethodId;
    public $amount;
    public $charge;
    public $netAmount;

    /**
     * @var string
     */
    public $message;

    public $image;
    public $plan;
    

    function getUserId() {
        return $this->userId;
    }

    function getPaymentMethodId() {
        return $this->paymentMethodId;
    }

    function getAmount() {
        return $this->amount;
    }

    function getCharge() {
        return $this->charge;
    }

    function getNetAmount() {
        return $this->netAmount;
    }

    function getMessage() {
        return $this->message;
    }

    function getImage() {
        return $this->image;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPaymentMethodId($paymentMethodId) {
        $this->paymentMethodId = $paymentMethodId;
    }

    function setAmount($ammount) {
        $this->amount = $ammount;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setNetAmount($netAmount) {
        $this->netAmount = $netAmount;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setImage($image) {
        $this->image = $image;
    }
    
    function getPlan() {
        return $this->plan;
    }

    function setPlan($plan) {
        $this->plan = $plan;
    }



}
