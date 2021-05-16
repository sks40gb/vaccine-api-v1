<?php

namespace Ziletech\Services\Notification;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\SmsRequestDTO;
use Ziletech\Services\Sms\DBSmsProvider;
use Ziletech\Services\Sms\SmsService;

class SmsNotificationService {

    /**
     * @var DAOFactory
     */
    protected $daoFactory;

    /**
     *
     * @var SmsService
     */
    protected $smsService;


    public function __construct($daoFactory) {
        $this->smsService = new SmsService(new DBSmsProvider($daoFactory));
        $this->daoFactory = $daoFactory;
    }


    public function sendSms(SmsRequestDTO $smsRequest) {
        $this->smsService->sendSMS($smsRequest);
    }

}
