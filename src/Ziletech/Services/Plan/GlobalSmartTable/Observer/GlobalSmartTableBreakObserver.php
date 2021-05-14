<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\Core\TreeObserver;
use Ziletech\Services\Plan\GlobalSmartTable\GlobalSmartTablePlanService;
use Ziletech\Services\Plan\GlobalSmartTable\Payout\GlobalSmartTableBreakPayout;
use Ziletech\Util\DateUtil;

class GlobalSmartTableBreakObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /*
     * @var Payout
     */
    private $payout;

    /*
     * @var SmartTablePlanService
     */
    private $planService;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->planService = new GlobalSmartTablePlanService($daoFactory);
        $this->payout = new GlobalSmartTableBreakPayout($daoFactory);
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        $this->startBreakingTable($userTree);
    }

    /**
     * Start breaking the table if it is eligible
     * @param UserTree $userTree
     */
    function startBreakingTable(UserTree $userTree) {
        //If the table is complete and mimium direct referral is available then close the table
        if ($this->isEligibleToBreak($userTree)) {
            $this->closeTable($userTree);
            $this->createNewEntry($userTree);
        }
    }

    private function createNewEntry(UserTree $userTree) {
        $superParent = $this->getSuperParent($userTree);
        //If the elment is not root element.
        if ($superParent->getParent() != null) {
            $parent = $superParent->getParent()->getUser();
            $nextLevel = $userTree->getLevel() + 1;
            //Add the new item into the tree.
            $this->planService->execute($superParent->getUser(), $superParent->getOwner(), $parent, $nextLevel);
        }
    }

    /**
     * If it has Super Parent and status is complete
     * @param UserTree $userTree
     * @return type
     */
    private function isEligibleToBreak(UserTree $userTree) {
        $hasParent = ($userTree->getParent() != null && $userTree->getParent()->getParent() != null);
        $isEligible = $hasParent && ($this->getSuperParent($userTree)->getStatus() == TreeConstant::STATUS_COMPLETE);
        return $isEligible;
    }

    /**
     * Close the table and make the payment.
     * @param UserTree $userTree
     */
    private function closeTable(UserTree $userTree) {
        $superParent = $this->getSuperParent($userTree);
        //Close the table
        $superParent->setStatus(TreeConstant::STATUS_CLOSE);
        $superParent->setCompletedDate(DateUtil::getCurrentDate());
        $this->payout->pay($userTree);
    }

    private function getSuperParent(UserTree $userTree) {
        return $userTree->getParent()->getParent();
    }

}
