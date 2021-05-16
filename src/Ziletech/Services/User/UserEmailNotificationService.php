<?php

namespace Ziletech\Services\User;

use stdClass;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Notification\EmailNotificationService;

class UserEmailNotificationService extends EmailNotificationService {

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
    }

    public function sendUserActiveEmail(UserDTO $userDTO) {
        if ($this->isEnabled(GenericCodeConstant::USER_ACTIVE_EMAIL)) {
            $content = new stdClass();
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::USER_ACTIVE_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendResetPasswordEmail(string $email, string $token, UserDTO $userDTO) {
        if ($this->isEnabled(GenericCodeConstant::RESET_PASSWORD)) {
            $content = new stdClass();
            $host = $this->daoFactory->getGenericCodeDAO()->getByCode(GenericCodeConstant::HOST_NAME)->getDescription();
            $description = $host . "/reset-password/" . $token;
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::RESET_PASSWORD, $content);
            $toArray = [$email];
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
