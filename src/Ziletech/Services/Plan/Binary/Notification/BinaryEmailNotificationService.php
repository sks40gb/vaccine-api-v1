<?php

namespace Ziletech\Services\Plan\Binary\Notification;

use stdClass;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Services\Plan\Core\Notification\EmailNotificationService;

class BinaryEmailNotificationService extends EmailNotificationService{

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
    }

    public function sendReferralBonusEmail(string $email, string $description) {
        //@TODO - use the right template for this.
        $content = new stdClass();
        $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::INVOICE, $content);
        $toArray = [$email];
        //$this->sendEmail($toArray, $template);
    }

}
