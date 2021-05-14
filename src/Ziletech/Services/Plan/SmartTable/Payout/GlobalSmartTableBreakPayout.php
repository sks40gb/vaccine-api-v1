<?php

namespace Ziletech\Services\Plan\SmartTable\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Payout\Payout;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\GlobalSmartTable\Transaction\GlobalSmartTableTransactionService;
use Ziletech\Services\UserBalanceService;

class GlobalSmartTableBreakPayout implements Payout {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function pay(UserTree $userTree) {
        $transactionService = new GlobalSmartTableTransactionService($this->daoFactory);
        $userBalanceService = new UserBalanceService($this->daoFactory);
        // create transaction for global entry
        if ($userTree->getLevel() == TreeConstant::LEVEL_FIRST) {
            $entryTransaction = $transactionService->createTransactionForGlobalEntry($userTree);
            //update user balance   
            $balance = $userBalanceService->createUserBalanceForUser($userTree->getUser());
            $userBalanceService->subtractBalance($balance, $entryTransaction->getAmount());
        }
    }

}
