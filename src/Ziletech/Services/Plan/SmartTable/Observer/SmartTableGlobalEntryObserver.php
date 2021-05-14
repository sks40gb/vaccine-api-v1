<?php

namespace Ziletech\Services\Plan\SmartTable\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\Core\TreeObserver;
use Ziletech\Services\Plan\GlobalSmartTable\GlobalSmartTablePlanService;
use Ziletech\Services\Plan\SmartTable\Payout\GlobalSmartTableBreakPayout;

class SmartTableGlobalEntryObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /*
     * @var Payout
     */
    private $globalPayout;

    /*
     * @var SmartTablePlanService
     */
    private $globalPlanService;

    private const MINIMUM_REFERRAL_REQRUIRED = 2;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->globalPayout = new GlobalSmartTableBreakPayout($daoFactory);
        $this->globalPlanService = new GlobalSmartTablePlanService($daoFactory);
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        if ($userTree->getParent() != null && $userTree->getParent()->getParent() != null) {
            $parent = $userTree->getParent();
            $superParent = $userTree->getParent()->getParent();
            //Make global entry for super parent
            $this->makeGlobalEntry($superParent);
            //Make global entry for owner's trees
            $this->makeGlobalEntryForOwner($userTree->getOwner());
        }
    }

    /**
     * Break the table if the parent has pending table.
     * @param UserTree $userTree
     */
    private function makeGlobalEntryForOwner(User $user) {
        $treeList = $this->daoFactory->getUserTreeDAO()->findByUserAndStatus($user, TreeConstant::STATUS_CLOSE);
        foreach ($treeList as $tree) {
            $this->makeGlobalEntry($tree);
        }
    }

    /**
     * If it is first level and minimum direct referral are met.
     * @param UserTree $userTree
     * @return boolean
     */
    private function isEligibleForGlobalEntry(UserTree $userTree) {
        $childrenList = $this->daoFactory->getUserTreeDAO()->findByOwner($userTree->getUser());
        if ($userTree->getStatus() == TreeConstant::STATUS_CLOSE && $childrenList != null && sizeof($childrenList) >= Self::MINIMUM_REFERRAL_REQRUIRED && $userTree->getLevel() == TreeConstant::LEVEL_FIRST) {
            return true;
        } else {
            return false;
        }
    }

    private function makeGlobalEntry(UserTree $userTree) {
        //Make global entry only for the first time
        if ($this->isEligibleForGlobalEntry($userTree)) {

            //Void the tree
            $userTree->setStatus(TreeConstant::STATUS_VOID);
            $this->daoFactory->getUserTreeDAO()->update($userTree);

            //Make the entry to global tree
            $user = $userTree->getUser();
            $owner = $userTree->getOwner();
            $parent = $userTree->getParent() == null ? null : $userTree->getParent()->getUser();
            $this->globalPayout->pay($userTree);
            $this->globalPlanService->execute($user, $owner, $parent);
        }
    }

}
