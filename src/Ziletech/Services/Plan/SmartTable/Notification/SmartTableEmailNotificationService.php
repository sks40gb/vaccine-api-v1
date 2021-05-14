<?php

namespace Ziletech\Services\Plan\SmartTable\Notification;

use stdClass;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Notification\EmailNotificationService;

class SmartTableEmailNotificationService extends EmailNotificationService {

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
    }

    public function sendSmartTableBreakEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::SMART_TABLE_BREAK_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::SMART_TABLE_BREAK_EMAIL, $content);
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

    public function sendReferralBonusEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::REFERRAL_BONUS_SMART_TABLE_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::REFERRAL_BONUS_SMART_TABLE_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendInoiveEmail(string $email, $userId) {
        if ($this->isEnabled(GenericCodeConstant::INVOICE)) {
            $content = $this->invoiceService->getInvoiceDTO($userId);
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::INVOICE, $content);
            $toArray = [$email];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendDepositEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::DEPOSIT_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::DEPOSIT_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendWithdrawEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::WITHDRAW_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::WITHDRAW_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendWithdrawChargeEmail(UserDTO $userDTO, string $description) {
        if ($this->isEnabled(GenericCodeConstant::WITHDRAW_CHARGE_EMAIL)) {
            $content = new stdClass();
            $content->description = $description;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::WITHDRAW_CHARGE_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
    }

    public function sendRegisterEmail(string $password, UserDTO $userDTO) {
        if ($this->isEnabled(GenericCodeConstant::REGISTER_EMAIL)) {
            $content = new stdClass();
            $content->password = $password;
            $content->user = $userDTO;
            $template = $this->emailTemplateService->getHtmlContent(GenericCodeConstant::REGISTER_EMAIL, $content);
            $toArray = [$userDTO->getEmail()];
            $this->sendEmail($toArray, $template);
        }
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

}
