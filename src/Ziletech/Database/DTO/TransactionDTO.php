<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Transaction;
use Ziletech\Util\DateUtil;

class TransactionDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $transactionId;

    /**
     * @var integer
     */
    public $amountType;

    /**
     * @var string
     */
    public $description;

    /**
     * @var UserDTO
     */
    public $user;
    public $amount;
    public $charge;
    public $postBal;

    /**
     * @var DateTime 
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;
    //only for front end 
    public $userName;
    public $name;

    public function __construct(Transaction $transaction = null) {
        if (isset($transaction)) {
            $this->copyFromDomain($transaction);
        }
    }

    public function copyFromDomain($transaction) {
        $this->id = $transaction->id;
        $this->transactionId = $transaction->transactionId;
        $this->amount = $transaction->amount;
        $this->amountType = $transaction->amountType;
        $this->charge = $transaction->charge;
        $this->postBal = $transaction->postBal;
        $this->description = $transaction->description;
        $this->createdAt = $transaction->createdAt;
        $this->updatedAt = $transaction->updatedAt;
    }

    public function copyToDomain($transaction) {
        $transaction->id = $this->id;
        $transaction->transactionId = $this->transactionId;
        $transaction->amount = $this->amount;
        $transaction->amountType = $this->amountType;
        $transaction->charge = $this->charge;
        $transaction->postBal = $this->postBal;
        $transaction->description = $this->description;
        $transaction->createdAt = $this->createdAt;
        $transaction->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getTransactionId() {
        return $this->transactionId;
    }

    function getAmountType() {
        return $this->amountType;
    }

    function getDescription() {
        return $this->description;
    }

    function getUser(): UserDTO {
        return $this->user;
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

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    function setAmountType($amountType) {
        $this->amountType = $amountType;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
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

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getUserName() {
        return $this->userName;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }
    
    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

}
