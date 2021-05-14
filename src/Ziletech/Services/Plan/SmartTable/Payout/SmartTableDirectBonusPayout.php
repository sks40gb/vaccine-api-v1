<?php

namespace Ziletech\Services\Plan\SmartTable\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Payout\Payout;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\SmartTable\Transaction\SmartTableTransactionService;
use Ziletech\Services\UserBalanceService;

class SmartTableDirectBonusPayout implements Payout {

    /**
     * @var DAOFactory
     */
    private $daoFactory; 
    
    /**
     * @var SmartTableTransactionService
     */
    private $transactionService;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->transactionService = new SmartTableTransactionService($daoFactory);
    }

    function pay(UserTree $userTree) {
        //If the the user is not root user and it is first level
        if ($userTree->getOwner() != null   &&  $userTree->getLevel() == TreeConstant::LEVEL_FIRST) {
            $transaction = $this->transactionService->createTransactionForDirectBonus($userTree);
            //update user balance   
            $userBalanceService = new UserBalanceService($this->daoFactory);
            $userBalance = $userBalanceService->createUserBalanceForUser($userTree->getOwner());
            $userBalanceService->updateUserBalance($userBalance, $transaction->getAmount());
        }
    }

}
