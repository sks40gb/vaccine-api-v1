<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Notification;

use stdClass;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Notification\EmailNotificationService;

class GlobalSmartTableEmailNotificationService extends EmailNotificationService {

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
    }

    public function sendGlobalEntryEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::GLOBAL_ENTRY_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::GLOBAL_ENTRY_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendGlobalTableBreak(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::GLOBAL_TABLE_BREAK_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::GLOBAL_TABLE_BREAK_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    private function isEnabled($code) {
        $template = $this->daoFactory->getGenericCodeDAO()->getByCodeTypeAndCode(CodeTypeConstant::EMAIL_TEMPLATE, $code);
        if ($template == null) {
            throw new ZiletechException("Email template with code $code is not configured.");
        }
        return $template->getEnabled();
    }

}
