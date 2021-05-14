<?php

namespace Ziletech\Database\DTO;

use DateTime;

class InvoiceDTO extends BaseDTO {

    public $status;

    /**
     *
     * @var UserDTO
     */
    public $user;

    /**
     * @var DateTime
     */
    public $payBy;
    public $planName;
    public $invoiceNumber;
    public $amount;
    public $printDate;
    public $invoiceDate;
    public $depositList = [];
    public $grandTotal = 0;

    
    function getGrandTotal() {
        return $this->grandTotal;
    }

    function setGrandTotal($grandTotal) {
        $this->grandTotal = $grandTotal;
    }

    
    function getStatus() {
        return $this->status;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getPayBy(): DateTime {
        return $this->payBy;
    }

    function getPlanName() {
        return $this->planName;
    }

    function getInvoiceNumber() {
        return $this->invoiceNumber;
    }

    function getAmount() {
        return $this->amount;
    }

    function getPrintDate() {
        return $this->printDate;
    }

    function getInvoiceDate() {
        return $this->invoiceDate;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function setPayBy(DateTime $payBy) {
        $this->payBy = $payBy;
    }

    function setPlanName($planName) {
        $this->planName = $planName;
    }

    function setInvoiceNumber($invoiceNumber) {
        $this->invoiceNumber = $invoiceNumber;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setPrintDate($printDate) {
        $this->printDate = $printDate;
    }

    function setInvoiceDate($invoiceDate) {
        $this->invoiceDate = $invoiceDate;
    }

    function getDepositList() {
        return $this->depositList;
    }

    function setDepositList($depositList) {
        $this->depositList = $depositList;
    }

}
