<?php

namespace Ziletech\Database\DTO;

use DateTime;

class UserDashboardToolbarDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $currentBalance;

    /**
     * @var integer
     */
    public $businessVolume;

    /**
     * @var integer
     */
    public $teamBusinessVolume;

    /**
     * @var integer
     */
    public $totalAccount;

    /**
     * @var integer
     */
    public $deposit;

    /**
     * @var integer
     */
    public $withdraws;

    /**
     * @var string
     */
    public $sponserName;

    /**
     * @var string
     */
    public $sponserId;

    /**
     * @var DateTime
     */
    public $activationDate;

    /**
     * @var DateTime
     */
    public $joinDate;

    /**
     * @var string
     */
    public $planName;

    function __construct() {
        $this->currentBalance = 0;
        $this->businessVolume = 0;
        $this->teamBusinessVolume = 0;
        $this->deposit = 0;
        $this->withdraws = 0;
    }

    function getCurrentBalance() {
        return $this->currentBalance;
    }

    function getTotalAccount() {
        return $this->totalAccount;
    }

    function getDeposit() {
        return $this->deposit;
    }

    function getWithdraws() {
        return $this->withdraws;
    }

    function setCurrentBalance($currentBalance) {
        $this->currentBalance = $currentBalance;
    }

    function setTotalAccount($totalAccount) {
        $this->totalAccount = $totalAccount;
    }

    function setDeposit($deposit) {
        $this->deposit = $deposit;
    }

    function setWithdraws($withdraws) {
        $this->withdraws = $withdraws;
    }

    function getBusinessVolume() {
        return $this->businessVolume;
    }

    function getTeamBusinessVolume() {
        return $this->teamBusinessVolume;
    }

    function setBusinessVolume($businessVolume) {
        $this->businessVolume = $businessVolume;
    }

    function setTeamBusinessVolume($teamBusinessVolume) {
        $this->teamBusinessVolume = $teamBusinessVolume;
    }

    function getSponserName() {
        return $this->sponserName;
    }

    function getSponserId() {
        return $this->sponserId;
    }

    function getActivationDate(): DateTime {
        return $this->activationDate;
    }

    function setSponserName($sponserName) {
        $this->sponserName = $sponserName;
    }

    function setSponserId($sponserId) {
        $this->sponserId = $sponserId;
    }

    function setActivationDate(?DateTime $activationDate) {
        $this->activationDate = $activationDate;
    }

    function getPlanName() {
        return $this->planName;
    }

    function setPlanName($planName) {
        $this->planName = $planName;
    }

    function getJoinDate(): DateTime {
        return $this->joinDate;
    }

    function setJoinDate(DateTime $joinDate) {
        $this->joinDate = $joinDate;
    }

}
