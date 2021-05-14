<?php

namespace Ziletech\Database\DTO;

class UserDetailsDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $totalTransacton;

    /**
     * @var integer
     */
    public $totalDeposit;

    /**
     * @var integer
     */
    public $totalWithdraw;

    /**
     * @var integer
     */
    public $totalLogin;

    function getTotalTransacton() {
        return $this->totalTransacton;
    }

    function getTotalDeposit() {
        return $this->totalDeposit;
    }

    function getTotalWithdraw() {
        return $this->totalWithdraw;
    }

    function getTotalLogin() {
        return $this->totalLogin;
    }

    function setTotalTransacton($totalTransacton) {
        $this->totalTransacton = $totalTransacton;
    }

    function setTotalDeposit($totalDeposit) {
        $this->totalDeposit = $totalDeposit;
    }

    function setTotalWithdraw($totalWithdraw) {
        $this->totalWithdraw = $totalWithdraw;
    }

    function setTotalLogin($totalLogin) {
        $this->totalLogin = $totalLogin;
    }

}
