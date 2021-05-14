<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\User;

class UserDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, User::class);
    }

    public function getByEmail($email): ?User {
        return $this->get(["email" => $email]);
    }

    public function getByUserName($userName): ?User {
        return $this->get(["userName" => $userName]);
    }

    public function findByOwner($owner) {
        return $this->find(["owner" => $owner]);
    }

    public function getByProperty($property, $userId): User {
        return $this->get([$property => $userId]);
    }

    public function getByResetPasswordToken($token) {
        return $this->get(["resetPasswordToken" => $token]);
    }

    public function findByDepartment($department) {
        $criteria = [];
        array_push($criteria, Property::getInstance("department", $department));
        array_push($criteria, Property::getInstance("inactive", false));
        return $this->filter($criteria);
    }

    public function getTotalUser() {
        return sizeof($this->findAll());
    }

    public function getTotalBlockUser() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::USER_DEACTIVE));
        return sizeof($this->filter($criteria));
    }
    public function getTotalActiveUser() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::USER_ACTIVE));
        return sizeof($this->filter($criteria));
    }

    public function getTotalEmailUnverifiedUser() {
        $criteria = [];
        array_push($criteria, Property::getInstance("emailVerify", StatusType::EMAIL_STATUS));
        return sizeof($this->filter($criteria));
    }

    public function getTotalPhoneUnverifiedUser() {
        $criteria = [];
        array_push($criteria, Property::getInstance("phoneVerify", StatusType::PHONE_STATUS));
        return sizeof($this->filter($criteria));
    }

    public function getTotalAccount($id) {
        $criteria = [];
        array_push($criteria, Property::getInstance("ownerId", $id));
        return sizeof($this->filter($criteria));
    }
    
     public function getByReferralId($referralId) {
        return $this->get(["referralId" => $referralId]);
    }

}
