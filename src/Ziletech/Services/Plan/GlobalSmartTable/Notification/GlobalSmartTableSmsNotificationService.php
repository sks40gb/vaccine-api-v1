<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Notification;

use Ziletech\Database\DTO\SmsRequestDTO;
use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\Notification\SmsNotificationService;

class GlobalSmartTableSmsNotificationService extends SmsNotificationService {

    /**
     * @var SmsRequestDTO
     */
    private $smsRequestDTO;

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
        $this->smsRequestDTO = new SmsRequestDTO();
    }

    public function sendGlobalTableBreakSms(UserDTO $userDTO, string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::GLOBAL_TABLE_BREAK_SMS)) {
            $description = "Dear " . $userDTO->getName() . $description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function sendGlobalTableEntrySms(UserDTO $userDTO, string $description) {
        if ($this->isNotificationEnabled(GenericCodeConstant::GLOBAL_ENTRY_SMS)) {
            $description = "Dear " . $userDTO->getName() . $description;
            $this->sendSms($this->copyToDTO($description, $userDTO->getPhone()));
        }
    }

    public function isNotificationEnabled($code) {
        $template = $this->daoFactory->getGenericCodeDAO()
                ->getByCodeTypeAndCode(CodeTypeConstant::SMS_NOTIFICATION, $code);
        if ($template == null) {
            throw new ZiletechException("Email template with code $code is not configured.");
        }
        return $$template->getEnabled();
    }

    private function copyToDTO(string $description, $mobile) {
        $this->smsRequestDTO->setNumbers($mobile);
        $this->smsRequestDTO->setMessage($description);
        return $this->smsRequestDTO;
    }

}
