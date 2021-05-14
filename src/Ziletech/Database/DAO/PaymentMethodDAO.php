<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\PaymentMethod;

class PaymentMethodDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, PaymentMethod::class);
    }

    public function getDepositMethod() {
        return sizeof($this->findAll());
    }

    public function getActivePaymentMethod() {
        return $this->find(["status" => 1]);
    }

}
