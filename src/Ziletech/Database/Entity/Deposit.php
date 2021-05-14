<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="deposit")
 * */
class Deposit extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="transaction_id") * */
    protected $transactionId;

    /** @Column(type="decimal", name="amount") * */
    protected $amount;

    /** @Column(type="decimal", name="rate") * */
    protected $rate;

    /** @Column(type="decimal", name="charge") * */
    protected $charge;

    /** @Column(type="decimal", name="net_amount") * */
    protected $netAmount;

    /** @Column(type="string", name="message") * */
    protected $message;

    /** @Column(type="string", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;
    
     /** @Column(type="integer", name="requested_plan_id") * */
    protected $requestedPlanId;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="PaymentMethod")
     * @JoinColumn(name="payment_type", referencedColumnName="id")
     */
    protected $paymentType;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="deposit_image_id", referencedColumnName="id")
     */
    protected $depositImage;

    function __construct() {
        $this->status = 0;
    }

    function getId() {
        return $this->id;
    }

    function getTransactionId() {
        return $this->transactionId;
    }

    function getAmount() {
        return $this->amount;
    }

    function getRate() {
        return $this->rate;
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

    function getStatus() {
        return $this->status;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getUser() {
        return $this->user;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setRate($rate) {
        $this->rate = $rate;
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

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function getPaymentType() {
        return $this->paymentType;
    }

    function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }

    function getDepositImage() {
        return $this->depositImage;
    }

    function setDepositImage($depositImage) {
        $this->depositImage = $depositImage;
    }
    
    function getRequestedPlanId() {
        return $this->requestedPlanId;
    }

    function setRequestedPlanId($requestedPlanId) {
        $this->requestedPlanId = $requestedPlanId;
    }


}
