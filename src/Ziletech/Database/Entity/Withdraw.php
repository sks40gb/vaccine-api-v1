<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="withdraw")
 * */
class Withdraw extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="WithdrawMethod")
     * @JoinColumn(name="method_id", referencedColumnName="id")
     */
    protected $withdrawMethod;

    /** @Column(type="string", name="transaction_id") * */
    protected $transactionId;

    /** @Column(type="decimal", name="amount") * */
    protected $amount;

    /** @Column(type="decimal", name="charge") * */
    protected $charge;

    /** @Column(type="decimal", name="net_amount") * */
    protected $netAmount;

    /** @Column(type="string", name="send_details") * */
    protected $sendDetails;

    /** @Column(type="string", name="mesage") * */
    protected $message;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    function __construct() {}

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
    }

    function getWithdrawMethod() {
        return $this->withdrawMethod;
    }

    function getTransactionId() {
        return $this->transactionId;
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

    function getSendDetails() {
        return $this->sendDetails;
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

    function setId($id) {
        $this->id = $id;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setWithdrawMethod($withdrawMethod) {
        $this->withdrawMethod = $withdrawMethod;
    }

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setNetAmount($netAmount) {
        $this->netAmount = $netAmount;
    }

    function setSendDetails($sendDetails) {
        $this->sendDetails = $sendDetails;
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

}
