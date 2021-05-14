<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\UserLogin;

class UserLoginDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var UserDTO
     */
    public $user;

    /**
     * @var string
     */
    public $userIp;

    /**
     * @var string
     */
    public $location;

    /**
     * @var string
     */
    public $detail;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    public function __construct(UserLogin $userLogin = null) {
        if (isset($userLogin)) {
            $this->copyFromDomain($userLogin);
        }
    }

    public function copyFromDomain($userLogin) {
        $this->id = $userLogin->id;
        $this->userIp = $userLogin->userIp;
        $this->location = $userLogin->location;
        $this->detail = $userLogin->detail;
        $this->createdAt = $userLogin->createdAt;
        $this->updatedAt = $userLogin->updatedAt;
    }

    public function copyToDomain($userLogin) {
        $userLogin->id = $this->id;
        $userLogin->userIp = $this->userIp;
        $userLogin->location = $this->location;
        $userLogin->detail = $this->detail;
        $userLogin->createdAt = $this->createdAt;
        $userLogin->updatedAt = $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getUser(): UserDTO {
        return $this->user;
    }

    function getUserIp() {
        return $this->userIp;
    }

    function getLocation() {
        return $this->location;
    }

    function getDetail() {
        return $this->detail;
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

    function setUser(UserDTO $user) {
        $this->user = $user;
    }

    function setUserIp($userIp) {
        $this->userIp = $userIp;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setDetail($detail) {
        $this->detail = $detail;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
