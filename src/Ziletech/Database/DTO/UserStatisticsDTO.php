<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Util\DateUtil;

class UserStatisticsDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $totalUser;

    /**
     * @var integer
     */
    public $totalBlockUser;

    /**
     * @var integer
     */
    public $totalEmailUnverifiedUser;//run manuually need to register 4 persion very good

    /**
     * @var integer
     */
    public $totalPhoneUnverifiedUser;
    
    /**
     * @var integer
     */
    public $totalActiveUser;

    function getTotalUser() {
        return $this->totalUser;
    }

    function getTotalBlockUser() {
        return $this->totalBlockUser;
    }

    function getTotalEmailUnverifiedUser() {
        return $this->totalEmailUnverifiedUser;
    }

    function getTotalPhoneUnverifiedUser() {
        return $this->totalPhoneUnverifiedUser;
    }

    function setTotalUser($totalUser) {
        $this->totalUser = $totalUser;
    }

    function setTotalBlockUser($totalBlockUser) {
        $this->totalBlockUser = $totalBlockUser;
    }

    function setTotalEmailUnverifiedUser($totalEmailUnverifiedUser) {
        $this->totalEmailUnverifiedUser = $totalEmailUnverifiedUser;
    }

    function setTotalPhoneUnverifiedUser($totalPhoneUnverifiedUser) {
        $this->totalPhoneUnverifiedUser = $totalPhoneUnverifiedUser;
    }
    
    function getTotalActiveUser() {
        return $this->totalActiveUser;
    }

    function setTotalActiveUser($totalActiveUser) {
        $this->totalActiveUser = $totalActiveUser;
    }

}
