<?php

namespace Ziletech\Services\Plan\SmartTable;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\PlanFactory;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;
use Ziletech\Services\Plan\SmartTable\Notification\SmartTableNotificationService;
use Ziletech\Services\Plan\SmartTable\Register\SmartTableRegisterService;
use Ziletech\Services\Plan\SmartTable\Transaction\SmartTableTransactionService;

class SmartTableFactory extends PlanFactory {

    /**
     *
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getRegisterService(): RegisterService {
        return new SmartTableRegisterService($this->daoFactory);
    }
    
    public function getNotificationService(): NotificationService {
        return new SmartTableNotificationService($this->daoFactory);
    }
    
    public function getTransactionService(): TransactionService {
        return new SmartTableTransactionService($this->daoFactory);
    }

}
