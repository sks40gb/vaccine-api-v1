<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\CodeType;

class CodeTypeDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, CodeType::class);
    }

    public function getByCode($code): ?CodeType {
        return $this->get(["description" => $code]);
    }
}

abstract class CodeTypeDescription {

    const COUNTRIES = "COUNTRIES";

}
