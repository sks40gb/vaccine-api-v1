<?php

namespace Ziletech\Services\Email;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Exceptions\ZiletechException;

class DBEmailProvider implements EmailProvider {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getHost() {
        return $this->getValue("EMAIL_HOST");
    }

    public function getPassword() {
        return $this->getValue("EMAIL_PASSWORD");
    }

    public function getPort() {
        return $this->getValue("EMAIL_PORT");
    }

    public function getSMTPAuth() {
        return $this->getValue("EMAIL_AUTH");
    }

    public function getSMTPAutoTLS() {
        return false;
    }

    public function getSMTPSecure() {
        return $this->getValue("EMAIL_SECURED");
    }

    public function getUsername() {
        return $this->getValue("EMAIL_FROM");
    }

    private function getValue($code) {
        $gc = $this->daoFactory->getGenericCodeDAO()->getByCodeTypeAndCode(CodeTypeConstant::EMAIL_CONFIG, $code);
        if ($gc == null) {
            throw new ZiletechException("Email code $code configuration is missing");
        }
        return $gc->getDescription();
    }

}

?>