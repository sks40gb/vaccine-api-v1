<?php

namespace Ziletech\Database\DTO;

class WithdrawStatisticsDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $withdrawMethod;

    /**
     * @var integer
     */
    public $withdrawAmount;

    /**
     * @var integer
     */
    public $withdrawCharge;

    /**
     * @var integer
     */
    public $numberOfWithdraw;

    /**
     * @var integer
     */
    public $successWithdraw;

    /**
     * @var integer
     */
    public $pendingWithdraw;

    /**
     * @var integer
     */
    public $refundedWithdraw;

    function getWithdrawMethod() {
        return $this->withdrawMethod;
    }

    function getWithdrawAmount() {
        return $this->withdrawAmount;
    }

    function getWithdrawCharge() {
        return $this->withdrawCharge;
    }

    function getNumberOfWithdraw() {
        return $this->numberOfWithdraw;
    }

    function getSuccessWithdraw() {
        return $this->successWithdraw;
    }

    function getPendingWithdraw() {
        return $this->pendingWithdraw;
    }

    function getRefundedWithdraw() {
        return $this->refundedWithdraw;
    }

    function setWithdrawMethod($withdrawMethod) {
        $this->withdrawMethod = $withdrawMethod;
    }

    function setWithdrawAmount($withdrawAmount) {
        $this->withdrawAmount = $withdrawAmount;
    }

    function setWithdrawCharge($withdrawCharge) {
        $this->withdrawCharge = $withdrawCharge;
    }

    function setNumberOfWithdraw($numberOfWithdraw) {
        $this->numberOfWithdraw = $numberOfWithdraw;
    }

    function setSuccessWithdraw($successWithdraw) {
        $this->successWithdraw = $successWithdraw;
    }

    function setPendingWithdraw($pendingWithdraw) {
        $this->pendingWithdraw = $pendingWithdraw;
    }

    function setRefundedWithdraw($refundedWithdraw) {
        $this->refundedWithdraw = $refundedWithdraw;
    }

}
