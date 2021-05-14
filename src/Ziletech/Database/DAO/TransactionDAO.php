<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Transaction;

class TransactionDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Transaction::class);
    }

    public function getAmountForDays($days) {
        $amount = 0;
        //@TODO - get the amount for days for Income TYPE.
        return $amount;
    }

    public function getAdminProfit() {
        //@TODO hard coded value to TransactionConstant
        $totalAmount = 0;
        foreach ($this->findAll() as $transaction) {
            if ($transaction->getAmountType() == 5) {
                $totalAmount += $transaction->getCharge();
            }
            if ($transaction->getAmountType() == 20 || $transaction->getAmountType() == 19) {
                $totalAmount += $transaction->getAmount();
            }
        }
        return $totalAmount;
    }

}
