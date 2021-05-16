<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\GenericCode;

class GenericCodeDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, GenericCode::class);
    }

    public function getByCode($code): ?GenericCode {
        return $this->get(["code" => $code]);
    }

    public function getByCodeTypeAndCode($codeTypeCode, $gcCode): ?GenericCode {
        return $this->get(["codeType.description" => $codeTypeCode, "code" => $gcCode]);
    }

}
