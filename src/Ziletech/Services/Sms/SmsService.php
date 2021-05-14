<?php

namespace Ziletech\Services\Sms;

use Ziletech\Database\DTO\SmsRequestDTO;

class SmsService {

    /**
     *
     * @var SmsProvider
     */
    private $smsProvider;

    public function __construct(SmsProvider $smsProvider) {
        $this->smsProvider = $smsProvider;
    }

    public function sendSMS(SmsRequestDTO $smsRequest) {
        $apiKey = $this->smsProvider->getSmsApi();
        $smsRequest->message = utf8_encode($smsRequest->message);
        $SMS_URL = $this->smsProvider->getSmsUrl();
        $SMS_URL = str_replace("{authkey}", $apiKey, $SMS_URL);
        $SMS_URL = str_replace("{numbers}", $smsRequest->numbers, $SMS_URL);
        $SMS_URL = str_replace("{message}", urlencode($smsRequest->message), $SMS_URL);
        $SMS_URL = str_replace("{sender}", "ALKARI", $SMS_URL);
        return file_get_contents($SMS_URL);
    }

}

?>