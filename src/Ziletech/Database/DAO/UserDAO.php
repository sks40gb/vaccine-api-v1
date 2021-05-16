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

    public function getByProperty($property, $userId): User {
        return $this->get([$property => $userId]);
    }

    public function getByResetPasswordToken($token) {
        return $this->get(["resetPasswordToken" => $token]);
    }

    public function getTotalUser() {
        return sizeof($this->findAll());
    }

}
