<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Deposit;

class DepositDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Deposit::class);
    }

    public function getTotalDeposit() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::DEPOSIT_APPROVE_STATUS));
        $totalAmount = 0;
        foreach ($this->filter($criteria) as $deposit) {
            $totalAmount += $deposit->getAmount();
        }
        return $totalAmount;
    }

    public function getUserTotalDeposit($id) {
        $criteria = [];
        array_push($criteria, Property::getInstance("user", $id));
        array_push($criteria, Property::getInstance("status", StatusType::DEPOSIT_APPROVE_STATUS));
        $totalAmount = 0;
        foreach ($this->filter($criteria) as $deposit) {
            $totalAmount += $deposit->getAmount();
        }
        return $totalAmount;
    }

    public function findDepositByuser($user) {
        $criteria = [];
        array_push($criteria, Property::getInstance("user", $user));
        return $this->filter($criteria);
    }

    public function getTotalDepositPending() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::DEPOSIT_PENDING_STATUS));
        return sizeof($this->filter($criteria));
    }

    public function getPendingDeposit() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::DEPOSIT_PENDING_STATUS));
        return $this->filter($criteria);
    }

    public function findByStatus(int $status) {
        $properties = [];
        array_push($properties, Property::getInstance("status", $status));
        return $this->filter($properties);
    }

}
