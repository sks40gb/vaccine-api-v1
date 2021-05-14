<?php

namespace Ziletech\Services\Plan\Binary\Transaction;

use Ziletech\Services\Plan\Core\Transaction\TransactionService;

class BinaryTransactionService extends TransactionService {

    public function __construct($daoFactory) {
        parent::__construct($daoFactory);
    }

}
