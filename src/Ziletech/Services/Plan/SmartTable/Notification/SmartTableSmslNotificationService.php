<?php

namespace Ziletech\Services\Plan\SmartTable\Notification;

use Ziletech\Database\DTO\SmsRequestDTO;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Database\Entity\User;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Notification\SmsNotificationService;

class SmartTableSmslNotificationService extends SmsNotificationService {

    /**
     * @var SmsRequestDTO
     */
    private $smsRequestDTO;

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
        $this->smsRequestDTO = new SmsRequestDTO();
    }

    public function sendSmartTableBreakSms(UserDTO $userDTO,string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::SMART_TABLE_BREAK_SMS)) {
             $description = "Dear " . $userDTO->getName() ." ".$description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendReferralBonusSms(UserDTO $userDTO, string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::REFERRAL_BONUS_SMART_TABLE_SMS)) {
            $description = "Dear " . $userDTO->getName() ." ".$description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendInoiveSms(string $description, $mobile) {
        if ($this->isNotificationEnabled(GenericCodeConstant::INVOICE_SMS)) {
            $this->sendSms($this->copyToDTO($description, $mobile));
        }
    }

    public function sendDepositSms(UserDTO $userDTO, string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::DEPOSIT_SMS)) {
            $description = "Dear " . $userDTO->getName() . " your " . $description
                    . " is Approved";
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendWithdrawSms(UserDTO $userDTO, string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::WITHDRAW_SMS)) {
            $description = "Dear " . $userDTO->getName() ." ".$description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendWithdrawChargeSms(UserDTO $userDTO,string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::WITHDRAW_CHARGE_SMS)) {
            $description = "Dear " . $userDTO->getName() ." ".$description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendRegisterSms(string $password, UserDTO $userDTO) {
        if ($this->isNotificationEnabled(GenericCodeConstant::REGISTER_SMS)) {
            $description = "Welcome " . $userDTO->getName() . " Thanks for Register In Alkarightworld "
                    . "here your Login Information"
                    . " User Id:- " . $userDTO->getUserName()
                    . " Password :- " . $password;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendUserActiveSms(UserDTO $userDTO) {
        if ($this->isNotificationEnabled(GenericCodeConstant::USER_ACTIVE_SMS)) {
            $description = "Hello " . $userDTO->getName() . " Your Id "
                    . $userDTO->getUserName()
                    . " is Activeted successfully "
                    . "Alkarightworld";
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    private function copyToDTO(string $description, $mobile) {
        $this->smsRequestDTO->setNumbers($mobile);
        $this->smsRequestDTO->setMessage($description);
        return $this->smsRequestDTO;
    }

    public function isNotificationEnabled($code) {
        $template = $this->daoFactory->getGenericCodeDAO()
                ->getByCodeTypeAndCode(CodeTypeConstant::SMS_NOTIFICATION,$code);
         if ($template == null) {
            throw new ZiletechException("Email template with code $code is not configured.");
        }
        return $$template->getEnabled();
    }

}
