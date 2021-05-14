<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Support;

class SupportDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Support::class);
    }

    public function pendingSupportCount() {
        return sizeof($this->getPendingSupports());
    }
    
     public function getPendingSupports() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::PENDING_SUPPORT_STATUS));
        return $this->filter($criteria,["orderBy" => "createdAt", "order" => "DESC"]);
    }

}
