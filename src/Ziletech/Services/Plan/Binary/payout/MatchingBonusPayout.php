<?php

namespace Ziletech\Services\Plan\Binary\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Payout\Payout;

class MatchingBonusPayout implements Payout {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function pay(UserTree $userTree) {
        $capping = 2000; // @TODO - move this to configuration under code type BINARY_PLAN.
        $cappingDays = 1; //@TODO - move this to configuration under code type BINARY_PLAN.
        $totalAmount = $this->daoFactory->getTransactionDAO()->getAmountForDays($cappingDays);
        if ($totalAmount < $capping) {
            //@TODO - payout the amount
        }
    }

}
