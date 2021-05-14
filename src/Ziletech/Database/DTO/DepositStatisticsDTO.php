<?php

namespace Ziletech\Database\DTO;

class DepositStatisticsDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $depositMethod;

    /**
     * @var integer
     */
    public $numberOfDeposits;

    /**
     * @var integer
     */
    public $totalDeposit;

    /**
     * @var integer
     */
    public $totalDepositPending;

    function getDepositMethod() {
        return $this->depositMethod;
    }

    function getNumberOfDeposits() {
        return $this->numberOfDeposits;
    }

    function getTotalDeposit() {
        return $this->totalDeposit;
    }

    function getTotalDepositPending() {
        return $this->totalDepositPending;
    }

    function setDepositMethod($depositMethod) {
        $this->depositMethod = $depositMethod;
    }

    function setNumberOfDeposits($numberOfDeposits) {
        $this->numberOfDeposits = $numberOfDeposits;
    }

    function setTotalDeposit($totalDeposit) {
        $this->totalDeposit = $totalDeposit;
    }

    function setTotalDepositPending($totalDepositPending) {
        $this->totalDepositPending = $totalDepositPending;
    }

}
