<?php

namespace Ziletech\Database\DTO;

class ContactUsDTO extends BaseDTO {

    public $address;
    public $footerText;
    public $email;
    public $number;

    function getAddress() {
        return $this->address;
    }

    function getFooterText() {
        return $this->footerText;
    }

    function getEmail() {
        return $this->email;
    }

    function getNumber() {
        return $this->number;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setFooterText($footerText) {
        $this->footerText = $footerText;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setNumber($number) {
        $this->number = $number;
    }

}
