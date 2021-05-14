<?php

namespace Ziletech\Services\Plan\SmartTable\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\Core\TreeObserver;
use Ziletech\Services\Plan\SmartTable\Payout\SmartTableBreakPayout;
use Ziletech\Services\Plan\SmartTable\SmartTablePlanService;
use Ziletech\Util\DateUtil;

class SmartTableBreakObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;
    /*
     * @var SmartTablePlanService
     */
    private $planService;
    /*
     * @var SmartTableBreakPayout
     */
    private $payout;

    private const MINIMUM_REFERRAL_REQRUIRED = 2;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->planService = new SmartTablePlanService($daoFactory);
        $this->payout = new SmartTableBreakPayout($daoFactory);
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
            $this->createNewEntry($userTree);
        }
        $this->closeTable($userTree);
        $this->closeTableForOwner($userTree->getOwner());
    }

    private function createNewEntry(UserTree $userTree) {
        $superParent = $this->getSuperParent($userTree);
        //If the elment is not root element.
        if ($superParent->getParent() != null) {
            $parent = $superParent->getParent()->getUser();
            $nextLevel = $superParent->getLevel() + 1;
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

    private function isEligibleToClose(?UserTree $userTree) {
        if($userTree == null){
            return false;
        }
        $childrenList = $this->daoFactory->getUserTreeDAO()->findByOwner($userTree->getUser());
        if ($userTree->getStatus() == TreeConstant::STATUS_COMPLETE && $childrenList != null && sizeof($childrenList) >= Self::MINIMUM_REFERRAL_REQRUIRED) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Break the table if the parent has pending table.
     * @param UserTree $userTree
     */
    private function closeTableForOwner(User $user) {
        $treeList = $this->daoFactory->getUserTreeDAO()->findByUserAndStatus($user, TreeConstant::STATUS_COMPLETE);
        foreach ($treeList as $tree) {
            $this->closeTable($tree);
        }
    }

    /**
     * Close the table and make the payment.
     * @param UserTree $userTree
     */
    private function closeTable(UserTree $userTree) {
        $superParent = $this->getSuperParent($userTree);
        if ($this->isEligibleToClose($superParent)) {
            //Close the table
            $superParent->setStatus(TreeConstant::STATUS_CLOSE);
            $superParent->setCompletedDate(DateUtil::getCurrentDate());
            $this->payout->pay($superParent);
        }
    }

    private function getSuperParent(UserTree $userTree) {
        return $userTree->getParent()->getParent();
    }

}
