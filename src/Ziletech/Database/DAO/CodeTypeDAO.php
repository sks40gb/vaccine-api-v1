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

        const JOB_TITLE = "JOB TITLE";
        const COUNTRIES = "COUNTRIES";
        const DEPARTMENT = "DEPARTMENT";
        const EMPLOYEE_STATUS = "EMPLOYEE STATUS";
        const CATEGORY = "CATEGORY";
        const LEAVE_TYPE = "LEAVE TYPE";
        const LEAVE_FOR = "LEAVE FOR";
        const SALARY_COMPONENT = "SALARY_COMPONENT";
        const BANK_NAME = "BANK_NAME";
        const EXPENSES_TYPE = "EXPENSES TYPE";
        const BL_ENTRY_TYPE = "BL ENTRY TYPE";
        const QUALIFICATION = "QUALIFICATION";
        const BPO_STATUS = "BPO STATUS";
        const BPO_DEPARTMENT = "BPO Associate";
        const ADMIN_ROLE = "admin";
     
    }