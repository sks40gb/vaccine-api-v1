<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Binary\BinaryFactory;
use Ziletech\Services\Plan\SmartTable\SmartTableFactory;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\Core\Register\RegisterService;
use Ziletech\Services\Plan\Core\Transaction\TransactionService;

abstract class PlanFactory {

    abstract public function getRegisterService(): RegisterService;

    abstract public function getNotificationService(): NotificationService;

    abstract public function getTransactionService(): TransactionService;

    public static function getFactory(DAOFactory $daoFactory) {
        
        $plan = $daoFactory->getGenericCodeDAO()->getByCodeTypeAndCode(CodeTypeConstant::PLAN, "PLAN_NAME");
        if ($plan == null) {
            throw new ZiletechException("Pleaes configure plan.");
        }
        $planName = $plan->getDescription();
        if ($planName == "BINARY") {
            return new BinaryFactory($daoFactory);
        } else if ($planName == "SMART TABLE") {
            return new SmartTableFactory($daoFactory);
        } else {
            throw new ZiletechException("Invalid Plan $planName");
        }
    }

}
