<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Deposit;
use Ziletech\Util\DateUtil;

class DepositDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $transactionId;

    /**
     * @var string
     */
    public $message;

    /**
     * @var decimal
     */
    public $rate;

    /**
     * @var decimal
     */
    public $amount;

    /**
     * @var decimal
     */
    public $charge;

    
    public $netAmount;

    /**
     * @var integer
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
     * @var PaymentMethodDTO
     */
    public $paymentType;

    /**
     * @var UserDTO
     */
    public $user;
    //    for show pending deposit
    public $requestDate;
    public $userName;
    public $name;
    public $userEmail;
    public $paymentMethodName;
    public $plan;
    public $planPrice;

    public function __construct(Deposit $deposit = null) {
        if (isset($deposit)) {
            $this->copyFromDomain($deposit);
        }
    }

    public function copyFromDomain($deposit) {
        $this->id = $deposit->id;
        $this->transactionId = $deposit->transactionId;
        $this->amount = $deposit->amount;
        $this->rate = $deposit->rate;
        $this->charge = $deposit->charge;
        $this->netAmount = $deposit->netAmount;
        $this->message = $deposit->message;
        $this->status = $deposit->status;
        $this->createdAt = $deposit->createdAt;
        $this->updatedAt = $deposit->updatedAt;
    }

    public function copyToDomain($deposit) {
        $deposit->id = $this->id;
        $deposit->transactionId = $this->transactionId;
        $deposit->amount = $this->amount;
        $deposit->rate = $this->rate;
        $deposit->charge = $this->charge;
        $deposit->netAmount = $this->netAmount;
        $deposit->message = $this->message;
        $deposit->status = $this->status;
        $deposit->createdAt = $this->createdAt;
        $deposit->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getTransactionId() {
        return $this->transactionId;
    }

    function getMessage() {
        return $this->message;
    }

    function getRate(): decimal {
        return $this->rate;
    }

    function getAmount(): decimal {
        return $this->amount;
    }

    function getCharge(): decimal {
        return $this->charge;
    }

    function getNetAmount() {
        return $this->netAmount;
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

    function getPaymentType(): PaymentMethodDTO {
        return $this->paymentType;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setRate(decimal $rate) {
        $this->rate = $rate;
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

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setPaymentType(PaymentMethodDTO $paymentType) {
        $this->paymentType = $paymentType;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function getRequestDate() {
        return $this->requestDate;
    }

    function getUserName() {
        return $this->userName;
    }

    function getUserEmail() {
        return $this->userEmail;
    }

    function getPaymentMethodName() {
        return $this->paymentMethodName;
    }

    function setRequestDate($requestDate) {
        $this->requestDate = $requestDate;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    function setPaymentMethodName($paymentMethodName) {
        $this->paymentMethodName = $paymentMethodName;
    }

    function getPlan() {
        return $this->plan;
    }

    function getPlanPrice() {
        return $this->planPrice;
    }

    function setPlan($plan) {
        $this->plan = $plan;
    }

    function setPlanPrice($planPrice) {
        $this->planPrice = $planPrice;
    }
    
    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }


}
