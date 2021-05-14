<?php

namespace Ziletech\Database\DTO;

class DashboardToolbarDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $adminProfit;

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
    public $pendingSupportTicket;

    function getAdminProfit() {
        return $this->adminProfit;
    }

    function getTotalDeposit() {
        return $this->totalDeposit;
    }

    function getTotalWithdraw() {
        return $this->totalWithdraw;
    }

    function getPendingSupportTicket() {
        return $this->pendingSupportTicket;
    }

    function setAdminProfit($adminProfit) {
        $this->adminProfit = $adminProfit;
    }

    function setTotalDeposit($totalDeposit) {
        $this->totalDeposit = $totalDeposit;
    }

    function setTotalWithdraw($totalWithdraw) {
        $this->totalWithdraw = $totalWithdraw;
    }

    function setPendingSupportTicket($pendingSupportTicket) {
        $this->pendingSupportTicket = $pendingSupportTicket;
    }

}
