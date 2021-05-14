<?php

namespace Ziletech\Database\DTO;

class TransactionRequestDTO extends BaseDTO {

    public $id;
    public $amount;
    public $reason;
    public $operation;
    
    function getId() {
        return $this->id;
    }

    function getAmount() {
        return $this->amount;
    }

    function getReason() {
        return $this->reason;
    }

    function getOperation() {
        return $this->operation;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setReason($reason) {
        $this->reason = $reason;
    }

    function setOperation($operation) {
        $this->operation = $operation;
    }

}
