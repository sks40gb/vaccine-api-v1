<?php

namespace Ziletech\Services\Plan\SmartTable\Transaction;

use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;
use Ziletech\Services\Plan\SmartTable\Notification\SmartTableNotificationService;

class SmartTableTransactionService extends TransactionService{

     /**
     *
     * @var SmartTableNotificationService
     */
    private $notification;
    
    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
        $this->notification = new SmartTableNotificationService($daoFactory);
    }

    public function createTransactionForSmartTableBreak(UserTree $userTree) {
        $transaction = EntityFactory::getTransaction();
        $transaction->setUser($userTree->getUser());
        $transaction->setAmount($this->daoFactory->getGenericCodeDAO()->getByCode("SMART_TABLE_BREAK_PAYOUT")->getDescription());
        $transaction->setTransactionId(uniqid());
        $transaction->setAmountType(self::SMART_TABLE_BONUS);
        $transaction->setDescription($transaction->getAmount() . " INR Credit For Smart Table Break ");
        $this->daoFactory->getTransactionDAO()->save($transaction);
        $this->notification->notifySmartTableBreak(DTOFactory::getUserDTO($transaction->getUser()), $transaction->getDescription());
        return $transaction;
    }
    

}
