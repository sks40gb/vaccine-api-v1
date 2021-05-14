<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Notification;

use Ziletech\Database\DTO\UserDTO;
use Ziletech\Services\Plan\GlobalSmartTable\Notification\GlobalSmartTableEmailNotificationService;
use Ziletech\Services\Plan\GlobalSmartTable\Notification\GlobalSmartTableSmsNotificationService;

class GlobalSmartTableNotificationService {

    /**
     * @var GlobalSmartTableEmailNotificationService
     */
    private $emailNotificationService;
    
    /**
     * @var GlobalSmartTableSmsNotificationService
     */
    private $smsNotificationService;

    public function __construct($daoFactory) {
        $this->emailNotificationService = new GlobalSmartTableEmailNotificationService($daoFactory);
        $this->smsNotificationService = new GlobalSmartTableSmsNotificationService($daoFactory);
    }

 
    public function notifyGlobalTableBreak(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendGlobalTableBreak($userDTO, $description);
        $this->smsNotificationService->sendGlobalTableBreakSms($userDTO,$description);
    }

     public function notifyGlobalEntry(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendGlobalEntryEmail($userDTO, $description);
        $this->smsNotificationService->sendGlobalTableEntrySms($userDTO,$description);
    }
}
