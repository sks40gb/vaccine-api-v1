<?php
namespace Ziletech\Services\Plan\Binary\Payout;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Binary\Transaction\BinaryTransactionService;
use Ziletech\Services\Plan\Core\Payout\Payout;
use Ziletech\Services\UserBalanceService;

class DirectBonusPayout implements Payout {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function pay(UserTree $userTree) {
        //@TODO - yet to be implemented.
        //@TODO - Bonus amount should be configurable.
        if ($userTree->getOwner() != null) {
            $transactionService = new BinaryTransactionService($this->daoFactory);
            $transaction = $transactionService->createTransactionForDirectBonus($userTree);
            //update user balance   
            $userBalanceService = new UserBalanceService($this->daoFactory);
            $userBalance = $userBalanceService->createUserBalanceForUser($userTree->getOwner());
            $userBalanceService->updateUserBalance($userBalance, $transaction->getAmount());
        }
    }

}
