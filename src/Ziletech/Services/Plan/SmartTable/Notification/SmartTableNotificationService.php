<?php

namespace Ziletech\Services\Plan\SmartTable\Notification;

use Ziletech\Database\DTO\UserDTO;
use Ziletech\Services\Plan\Core\Notification\NotificationService;
use Ziletech\Services\Plan\SmartTable\Notification\SmartTableEmailNotificationService;

class SmartTableNotificationService implements NotificationService {

    /**
     * @var SmartTableEmailNotificationService
     */
    private $emailNotificationService;

    /**
     * @var SmartTableSmslNotificationService
     */
    private $smsNotificationService;

    public function __construct($daoFactory) {
        $this->emailNotificationService = new SmartTableEmailNotificationService($daoFactory);
        $this->smsNotificationService = new SmartTableSmslNotificationService($daoFactory);
    }

    public function notifyDirectReferral(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendReferralBonusEmail($userDTO, $description);
        $this->smsNotificationService->sendReferralBonusSms($userDTO, $description);
    }


    public function notifySmartTableBreak(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendSmartTableBreakEmail($userDTO, $description);
        $this->smsNotificationService->sendSmartTableBreakSms($userDTO, $description);
    }

    public function sendInvoice(string $email, $userId) {
        $this->emailNotificationService->sendInoiveEmail($email, $userId);
    }

    public function notifyDeposit(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendDepositEmail($userDTO, $description);
        $this->smsNotificationService->sendDepositSms($userDTO, $description);
    }

    public function notifyWithdraw(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendWithdrawEmail($userDTO, $description);
        $this->smsNotificationService->sendWithdrawSms($userDTO, $description);
    }

    public function notifyWithdrawCharge(UserDTO $userDTO, string $description) {
        $this->emailNotificationService->sendWithdrawChargeEmail($userDTO, $description);
        $this->smsNotificationService->sendWithdrawChargeSms($userDTO, $description);
    }

    public function notifyRegister(string $password, UserDTO $userDTO) {
        $this->emailNotificationService->sendRegisterEmail($password, $userDTO);
        $this->smsNotificationService->sendRegisterSms($password, $userDTO);
    }

    public function notifyUserActive(UserDTO $userDTO) {
        $this->emailNotificationService->sendUserActiveEmail($userDTO);
        $this->smsNotificationService->sendUserActiveSms($userDTO);
    }

    public function sendResetPasswordEmail(string $email, string $token, UserDTO $userDTO) {
        $this->emailNotificationService->sendResetPasswordEmail($email, $token, $userDTO);
    }

}
