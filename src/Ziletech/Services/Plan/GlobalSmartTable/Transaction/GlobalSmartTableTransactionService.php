<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Transaction;

use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;
use Ziletech\Services\Plan\GlobalSmartTable\Notification\GlobalSmartTableNotificationService;

class GlobalSmartTableTransactionService extends TransactionService {

    /**
     *
     * @var GlobalSmartTableNotificationService
     */
    private $notification;

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
        $this->notification = new GlobalSmartTableNotificationService($daoFactory);
    }

    public function createTransactionForGlobalEntry(UserTree $userTree) {
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($userTree->getUser());
        $transaction->setAmount($this->daoFactory->getGenericCodeDAO()->getByCode("GLOBAL_ENTRY_FEES")->getDescription());
        $transaction->setTransactionId(uniqid());
        $transaction->setAmountType(self::GLOBAL_ENTRY);
        $transaction->setDescription($transaction->getAmount() . " INR Debited For Global Entry ");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyGlobalEntry(DTOFactory::getUserDTO($transaction->getUser()), $transaction->getDescription());
        return $transaction;
    }

    public function createTransactionForGolbalTableBreak(UserTree $userTree) {
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($userTree->getUser());
        $transaction->setAmount($this->daoFactory->getGenericCodeDAO()->getByCode("GOLBAL_TABLE_BREAK_PAYOUT")->getDescription());
        $transaction->setTransactionId(uniqid());
        $transaction->setAmountType(self::GLOBAL_TABLE_BONUS);
        $transaction->setDescription($transaction->getAmount() . " INR Credit For Global Table Break ");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifyGlobalTableBreak(DTOFactory::getUserDTO($transaction->getUser()), $transaction->getDescription());
        return $transaction;
    }

}
