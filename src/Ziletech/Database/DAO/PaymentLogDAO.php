<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\PaymentLog;

class PaymentLogDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, PaymentLog::class);
    }
}
