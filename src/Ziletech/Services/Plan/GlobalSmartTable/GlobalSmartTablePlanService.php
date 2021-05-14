<?php

namespace Ziletech\Services\Plan\GlobalSmartTable;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\PlanService;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\GlobalSmartTable\Observer\GlobalSmartTableBreakObserver;
use Ziletech\Services\Plan\GlobalSmartTable\Observer\GlobalSmartTableUpdateStatusObserver;

class GlobalSmartTablePlanService extends PlanService {

    public function __construct(DAOFactory $daoFactory) {
        $positionLocator = new GlobalSmartTablePositionLocator();
        $parentFinder = new GlobalSmartTableParentFinder($daoFactory, $positionLocator);
        parent::__construct($daoFactory, $parentFinder, $positionLocator, TreeConstant::TYPE_B);
    }

    public function getRoot(): ?UserTree {
        return $this->daoFactory->getUserTreeDAO()->getRootUser($this->type);
    }

    public function execute(User $user, ?User $owner, ?User $parent, $level = TreeConstant::LEVEL_FIRST): UserTree {

        $this->isRootUserAvailable();

        //Update Status Observer
        $treeUpdateStatus = new GlobalSmartTableUpdateStatusObserver($this->daoFactory);
        $this->subscribe($treeUpdateStatus);

        //Break table Observer
        $treeBreak = new GlobalSmartTableBreakObserver($this->daoFactory);
        $this->subscribe($treeBreak);

        $userTree = parent::execute($user, $owner, $parent, $level);
        return $userTree;
    }

    private function isRootUserAvailable() {
        $count = $this->daoFactory->getUserTreeDAO()->getCount(["type" => 1]);
        if ($count < 1) {
            throw new ZiletechException("Root user is missing in Tree for Global Table");
        }
    }

}
