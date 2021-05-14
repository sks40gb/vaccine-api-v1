<?php

namespace Ziletech\Services\Plan\Binary\Notification;

use Ziletech\Services\Plan\Core\Notification\EmailNotificationService;
use Ziletech\Services\Plan\Core\Notification\NotificationService;

class BinaryNotificationService implements NotificationService {

    /**
     * @var EmailNotificationService
     */
    private $emailNotificationService;

    public function __construct($daoFactory) {
        $this->emailNotificationService = new BinaryEmailNotificationService($daoFactory);
    }

    public function notifyDirectReferral(string $email, string $description) {
        $this->emailNotificationService->sendReferralBonusEmail($email, $description);
    }

    public function notifyActiveUser(string $email, string $description) {
        $this->emailNotificationService->sendActiveUser($email, $description);
    }

}
