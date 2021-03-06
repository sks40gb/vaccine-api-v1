<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\GenericCode;

class GenericCodeDAO extends BaseDAO {

    public const VACCINE_CENTER_URL = "VACCINE_CENTER_URL";
    public const DISTRICT_IDS = "DISTRICT_IDS";

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
