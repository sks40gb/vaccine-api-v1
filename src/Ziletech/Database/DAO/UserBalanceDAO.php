<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\UserBalance;

class UserBalanceDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, UserBalance::class);
    }
    
    public function getBalanceByUser($user){
        return $this->get(["user" => $user]);
    }

    public function getUserBalance($id) {
        $userBalance = $this->get(["user" => $id]);
        if ($userBalance != null) {
            return $userBalance->getBalance();
        } else {
            return 0;
        }
    }

}
