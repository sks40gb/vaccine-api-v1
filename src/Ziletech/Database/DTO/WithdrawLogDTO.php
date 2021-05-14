<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Withdraw;
use Ziletech\Util\DateUtil;

class WithdrawLogDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $transactionId;

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
     * @var string
     */
    public $sendDetails;

    /**
     * @var string
     */
    public $message;

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
     * @var WithdrawMethodDTO
     */
    public $withdrawMethod;
    //only for front end 
    public $userName;
    public $name;
    public $accountNumber;
    public $bankName;
    public $branchName;
    public $ifsc;
    public $panNumber;

    public function __construct(Withdraw $withdrawLog = null) {
        if (isset($withdrawLog)) {
            $this->copyFromDomain($withdrawLog);
        }
    }

    public function copyFromDomain($withdrawLog) {
        $this->id = $withdrawLog->id;
        $this->transactionId = $withdrawLog->transactionId;
        $this->amount = $withdrawLog->amount;
        $this->charge = $withdrawLog->charge;
        $this->netAmount = $withdrawLog->netAmount;
        $this->sendDetails = $withdrawLog->sendDetails;
        $this->message = $withdrawLog->message;
        $this->status = $withdrawLog->status;
        $this->createdAt = $withdrawLog->createdAt;
        $this->updatedAt = $withdrawLog->updatedAt;
    }

    public function copyToDomain($withdrawLog) {
        $withdrawLog->id = $this->id;
        $withdrawLog->transactionId = $this->transactionId;
        $withdrawLog->amount = $this->amount;
        $withdrawLog->charge = $this->charge;
        $withdrawLog->netAmount = $this->netAmount;
        $withdrawLog->sendDetails = $this->sendDetails;
        $withdrawLog->message = $this->message;
        $withdrawLog->status = $this->status;
        $withdrawLog->createdAt = $this->createdAt;
        $withdrawLog->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getTransactionId() {
        return $this->transactionId;
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

    function getSendDetails() {
        return $this->sendDetails;
    }

    function getMessage() {
        return $this->message;
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

    function setId($id) {
        $this->id = $id;
    }

    function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
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

    function setSendDetails($sendDetails) {
        $this->sendDetails = $sendDetails;
    }

    function setMessage($message) {
        $this->message = $message;
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

    function getUserName() {
        return $this->userName;
    }

    function getWithdrawMethod() {
        return $this->withdrawMethod;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setWithdrawMethod($withdrawMethod) {
        $this->withdrawMethod = $withdrawMethod;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getAccountDetails() {
        return $this->accountDetails;
    }

    function setAccountDetails($accountDetails) {
        $this->accountDetails = $accountDetails;
    }
    
    function getAccountNumber() {
        return $this->accountNumber;
    }

    function getBankName() {
        return $this->bankName;
    }

    function getBranchName() {
        return $this->branchName;
    }

    function getIfsc() {
        return $this->ifsc;
    }

    function getPanNumber() {
        return $this->panNumber;
    }

    function setAccountNumber($accountNumber) {
        $this->accountNumber = $accountNumber;
    }

    function setBankName($bankName) {
        $this->bankName = $bankName;
    }

    function setBranchName($branchName) {
        $this->branchName = $branchName;
    }

    function setIfsc($ifsc) {
        $this->ifsc = $ifsc;
    }

    function setPanNumber($panNumber) {
        $this->panNumber = $panNumber;
    }


}
