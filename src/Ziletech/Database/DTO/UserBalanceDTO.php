<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\UserBalance;

class UserBalanceDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;
    public $balance;
    public $businessVolume;
    public $teamBusinessVolume;

    /**
     * @var UserDTO
     */
    public $user;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    public function __construct(UserBalance $userBalance = null) {
        if (isset($userBalance)) {
            $this->copyFromDomain($userBalance);
        }
    }

    public function copyFromDomain($userBalance) {
        $this->id = $userBalance->id;
        $this->balance = $userBalance->balance;
        $this->createdAt = $userBalance->createdAt;
        $this->updatedAt = $userBalance->updatedAt;
        $this->businessVolume = $userBalance->businessVolume;
        $this->teamBusinessVolume = $userBalance->teamBusinessVolume;
    }

    public function copyToDomain($userBalance) {
        $userBalance->id = $this->id;
        $userBalance->balance = $this->balance;
        $userBalance->createdAt = $this->createdAt;
        $userBalance->updatedAt = $this->updatedAt;
        $userBalance->businessVolume = $this->businessVolume;
        $userBalance->teamBusinessVolume = $this->teamBusinessVolume;
    }

    function getId() {
        return $this->id;
    }

    function getBalance() {
        return $this->balance;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBalance($balance) {
        $this->balance = $balance;
    }

    function setUser(UserDTO $user = null) {
        $this->user = $user;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt = null) {
        $this->updatedAt = $updatedAt;
    }

    function getBusinessVolume() {
        return $this->businessVolume;
    }

    function getTeamBusinessVolume() {
        return $this->teamBusinessVolume;
    }

    function setBusinessVolume($businessVolume) {
        $this->businessVolume = $businessVolume;
    }

    function setTeamBusinessVolume($teamBusinessVolume) {
        $this->teamBusinessVolume = $teamBusinessVolume;
    }

}
