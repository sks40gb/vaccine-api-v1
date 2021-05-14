<?php

namespace Ziletech\Services\Plan\SmartTable\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Payout\Payout;
use Ziletech\Services\Plan\SmartTable\Transaction\SmartTableTransactionService;
use Ziletech\Services\UserBalanceService;

class SmartTableBreakPayout implements Payout {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function pay(UserTree $userTree) {
        $transactionService = new SmartTableTransactionService($this->daoFactory);
        $transaction = $transactionService->createTransactionForSmartTableBreak($userTree);
        //update user balance   
        $userBalanceService = new UserBalanceService($this->daoFactory);
        $userBalance = $userBalanceService->createUserBalanceForUser($userTree->getUser());
        $userBalanceService->updateUserBalance($userBalance, $transaction->getAmount());
    }

}
