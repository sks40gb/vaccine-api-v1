<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\WithdrawMethod;

class WithdrawMethodDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, WithdrawMethod::class);
    }

    public function getWithdrawMethod() {
        return sizeof($this->findAll());
    }
    
    public function getActiveWithdrawMethod() {
        return $this->find(["status"=>true]);
    }

}
