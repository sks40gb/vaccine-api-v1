<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\User;

class DepositPlanStatisticsDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $totalPlan;

    /**
     * @var integer
     */
    public $totalActivePlan;

    /**
     * @var integer
     */
    public $totalDeactivePlan;

    function getTotalPlan() {
        return $this->totalPlan;
    }

    function getTotalActivePlan() {
        return $this->totalActivePlan;
    }

    function getTotalDeactivePlan() {
        return $this->totalDeactivePlan;
    }

    function setTotalPlan($totalPlan) {
        $this->totalPlan = $totalPlan;
    }

    function setTotalActivePlan($totalActivePlan) {
        $this->totalActivePlan = $totalActivePlan;
    }

    function setTotalDeactivePlan($totalDeactivePlan) {
        $this->totalDeactivePlan = $totalDeactivePlan;
    }

}
