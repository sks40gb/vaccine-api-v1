<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\UserLogin;

class UserLoginDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, UserLogin::class);
    }
}
