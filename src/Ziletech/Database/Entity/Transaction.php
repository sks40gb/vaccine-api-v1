<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="transaction")
 * */
class Transaction extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="string", name="transaction_id") * */
    protected $transactionId;

    /** @Column(type="decimal", name="amount") * */
    protected $amount;

    /** @Column(type="decimal", name="charge") * */
    protected $charge;

    /** @Column(type="decimal", name="post_bal") * */
    protected $postBal;

    /** @Column(type="integer", name="amount_type") * */
    protected $amountType;

    /** @Column(type="string", name="description") * */
    protected $description;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
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

    function getPostBal() {
        return $this->postBal;
    }

    function getAmountType() {
        return $this->amountType;
    }

    function getDescription() {
        return $this->description;
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

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setPostBal($postBal) {
        $this->postBal = $postBal;
    }

    function setAmountType($amountType) {
        $this->amountType = $amountType;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}

class TransactionConstant{
    const NONE = 0;
}