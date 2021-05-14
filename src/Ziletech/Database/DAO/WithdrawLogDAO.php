<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\Withdraw;

class WithdrawLogDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Withdraw::class);
    }

    public function getNumberOfWithdraw($userId = null) {
        return sizeof($this->find(["user" => $userId]));
    }

    public function getWithdrawAmount() {
        $totalAmount = 0;
        foreach ($this->findAll() as $withdrawLog) {
            if ($withdrawLog->getStatus() == 2) {
                $totalAmount += $withdrawLog->getAmount();
            }
        }
        return $totalAmount;
    }

    public function getWithdrawCharge() {
        $totalCharge = 0;
        foreach ($this->findAll() as $withdrawLog) {
            if ($withdrawLog->getStatus() == 2) {
                $totalCharge += $withdrawLog->getCharge();
            }
        }
        return $totalCharge;
    }

    public function findByStatus(int $status) {
        $properties = [];
        array_push($properties, Property::getInstance("status", $status));
        return $this->filter($properties);
    }

    public function findByUser(?User $user) {
        if ($user !== null) {
            $properties = [];
            array_push($properties, Property::getInstance("user", $user));
            $results = $this->filter($properties);
        } else {
            $results = $this->findAll();
        }
        return $results;
    }

}
