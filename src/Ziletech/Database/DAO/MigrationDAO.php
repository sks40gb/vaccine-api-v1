<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Migration;

class MigrationDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Migration::class);
    }
}
