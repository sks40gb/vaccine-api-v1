<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Payout\Payout;
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
        $transaction = $transactionService->createTransactionForGolbalTableBreak($userTree);
        //update user balance   
        $userBalanceService = new UserBalanceService($this->daoFactory);
        $userBalance = $userBalanceService->createUserBalanceForUser($userTree->getUser());
        $userBalanceService->updateUserBalance($userBalance, $transaction->getAmount());

        // create transaction for global entry
        $entryTransaction = $transactionService->createTransactionForGlobalEntry($userTree);
        //update user balance   
        $balance = $userBalanceService->createUserBalanceForUser($userTree->getUser());
        $userBalanceService->subtractBalance($balance, $entryTransaction->getAmount());
    }

}
