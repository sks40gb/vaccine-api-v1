<?php

namespace Ziletech\Database\DTO;

class SettingDTO extends BaseDTO {

    public $tableBreakPayemnt;
    public $directReferralPayemnt;
    public $emailFrom;
    public $emailBody;
    public $adminCharge;
    public $tds;
    public $globalTableBreakPayment;
    public $minimumWithdraw;
    public $globalEntry;

    function getTableBreakPayemnt() {
        return $this->tableBreakPayemnt;
    }

    function getDirectReferralPayemnt() {
        return $this->directReferralPayemnt;
    }

    function getEmailFrom() {
        return $this->emailFrom;
    }

    function getEmailBody() {
        return $this->emailBody;
    }

    function setTableBreakPayemnt($tableBreakPayemnt) {
        $this->tableBreakPayemnt = $tableBreakPayemnt;
    }

    function setDirectReferralPayemnt($directReferralPayemnt) {
        $this->directReferralPayemnt = $directReferralPayemnt;
    }

    function setEmailFrom($emailFrom) {
        $this->emailFrom = $emailFrom;
    }

    function setEmailBody($emailBody) {
        $this->emailBody = $emailBody;
    }

    function getAdminCharge() {
        return $this->adminCharge;
    }

    function getTds() {
        return $this->tds;
    }

    function setAdminCharge($adminCharge) {
        $this->adminCharge = $adminCharge;
    }

    function setTds($tds) {
        $this->tds = $tds;
    }
    
    function getGlobalTableBreakPayment() {
        return $this->globalTableBreakPayment;
    }

    function setGlobalTableBreakPayment($globalTableBreakPayment) {
        $this->globalTableBreakPayment = $globalTableBreakPayment;
    }

    function getMinimumWithdraw() {
        return $this->minimumWithdraw;
    }

    function setMinimumWithdraw($minimumWithdraw) {
        $this->minimumWithdraw = $minimumWithdraw;
    }
    
    function getGlobalEntry() {
        return $this->globalEntry;
    }

    function setGlobalEntry($globalEntry) {
        $this->globalEntry = $globalEntry;
    }

}
