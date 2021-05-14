<?php

namespace Ziletech\Services\Plan\Binary;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Services\Plan\Binary\Notification\BinaryNotificationService;
use Ziletech\Services\Plan\Binary\Register\BinaryRegisterService;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;
use Ziletech\Services\Plan\Binary\Transaction\BinaryTransactionService;

class BinaryFactory extends PlanFactory {

    /**
     *
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getRegisterService(): RegisterService {
        return new BinaryRegisterService($this->daoFactory);
    }
    
    public function getNotificationService(): NotificationService {
        return new BinaryNotificationService($this->daoFactory);
    }
    
    public function getTransactionService(): TransactionService {
        return new BinaryTransactionService($this->daoFactory);
    }

}
