<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\PaymentLog;

class PaymentLogDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $custom;

    /**
     * @var decimal
     */
    public $amount;

    /**
     * @var decimal
     */
    public $charge;

    /**
     * @var decimal
     */
    public $netAmount;

    /**
     * @var decimal
     */
    public $btcAmount;

    /**
     * @var string
     */
    public $btcAccount;

    /**
     * @var string
     */
    public $status;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @var UserDTO
     */
    public $member;

    /**
     * @var PaymentMethodDTO
     */
    public $paymentType;

    public function __construct(PaymentLog $paymentLog = null) {
        if (isset($paymentLog)) {
            $this->copyFromDomain($paymentLog);
        }
    }

    public function copyFromDomain($paymentLog) {
        $this->id = $paymentLog->id;
        $this->custom = $paymentLog->custom;
        $this->amount = $paymentLog->amount;
        $this->charge = $paymentLog->charge;
        $this->netAmount = $paymentLog->netAmount;
        $this->usd = $paymentLog->usd;
        $this->btcAmount = $paymentLog->btcAmount;
        $this->btcAccount = $paymentLog->btcAccount;
        $this->status = $paymentLog->status;
        $this->createdAt = $paymentLog->createdAt;
        $this->updatedAt = $paymentLog->updatedAt;
    }

    public function copyToDomain($paymentLog) {
        $paymentLog->id = $this->id;
        $paymentLog->custom = $this->custom;
        $paymentLog->amount = $this->amount;
        $paymentLog->charge = $this->charge;
        $paymentLog->netAmount = $this->netAmount;
        $paymentLog->usd = $this->usd;
        $paymentLog->btcAmount = $this->btcAmount;
        $paymentLog->btcAccount = $this->btcAccount;
        $paymentLog->status = $this->status;
        $paymentLog->createdAt = $this->createdAt;
        $paymentLog->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getCustom() {
        return $this->custom;
    }

    function getAmount(): decimal {
        return $this->amount;
    }

    function getCharge(): decimal {
        return $this->charge;
    }

    function getNetAmount(): decimal {
        return $this->netAmount;
    }

    function getBtcAmount(): decimal {
        return $this->btcAmount;
    }

    function getBtcAccount() {
        return $this->btcAccount;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function getMember(): UserDTO {
        return $this->member;
    }

    function getPaymentType(): PaymentMethodDTO {
        return $this->paymentType;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCustom($custom) {
        $this->custom = $custom;
    }

    function setAmount(decimal $amount) {
        $this->amount = $amount;
    }

    function setCharge(decimal $charge) {
        $this->charge = $charge;
    }

    function setNetAmount(decimal $netAmount) {
        $this->netAmount = $netAmount;
    }

    function setBtcAmount(decimal $btcAmount) {
        $this->btcAmount = $btcAmount;
    }

    function setBtcAccount($btcAccount) {
        $this->btcAccount = $btcAccount;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setMember(UserDTO $member) {
        $this->member = $member;
    }

    function setPaymentType(PaymentMethodDTO $paymentType) {
        $this->paymentType = $paymentType;
    }

}
