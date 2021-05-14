<?php

namespace Ziletech\Services\Sms;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Exceptions\ZiletechException;

class DBSmsProvider implements SmsProvider {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getSmsUrl() {
        return $this->getValue("SMS_URL");
    }
    
    public function getSmsApi() {
        return $this->getValue("SMS_API");
    }

   

    private function getValue($code) {
        $gc = $this->daoFactory->getGenericCodeDAO()->getByCodeTypeAndCode(CodeTypeConstant::SMS_CONFIG, $code);
        if ($gc == null) {
            throw new ZiletechException("SMS code $code configuration is missing");
        }
        return $gc->getDescription();
    }

}

?>