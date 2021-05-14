<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Plan;

class PlanDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Plan::class);
    }

    public function getTotalActivePlan() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::ACTIVE_PLAN_STATUS));
        return sizeof($this->filter($criteria));
    }

    public function getTotalDeactivePlan() {
        $criteria = [];
        array_push($criteria, Property::getInstance("status", StatusType::DEACTIVE_PLAN_STATUS));
        return sizeof($this->filter($criteria));
    }

    public function getTotalPlan() {
        return sizeof($this->findAll());
    }

}
