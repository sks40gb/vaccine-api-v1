<?php

namespace Ziletech\Services\Plan\SmartTable;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\PlanService;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\SmartTable\Observer\SmartTableBreakObserver;
use Ziletech\Services\Plan\SmartTable\Observer\SmartTableDirectObserver;
use Ziletech\Services\Plan\SmartTable\Observer\SmartTableGlobalEntryObserver;
use Ziletech\Services\Plan\SmartTable\Observer\SmartTableUpdateStatusObserver;

class SmartTablePlanService extends PlanService {

    public function __construct(DAOFactory $daoFactory) {
        $positionLocator = new SmartTablePositionLocator();
        $parentFinder = new SmartTableParentFinder($daoFactory, $positionLocator);
        parent::__construct($daoFactory, $parentFinder, $positionLocator, TreeConstant::TYPE_A);
    }

    public function getRoot(): ?UserTree {
        return $this->daoFactory->getUserTreeDAO()->getRootUser($this->type);
    }

    public function execute(User $user, ?User $owner, ?User $parent, $level = TreeConstant::LEVEL_FIRST): UserTree {

        $this->isRootUserAvailable();

        //Update Status Observer
        $treeUpdateStatus = new SmartTableUpdateStatusObserver($this->daoFactory);
        $this->subscribe($treeUpdateStatus);

        //Add new item Oberver
        $direct = new SmartTableDirectObserver($this->daoFactory);
        $this->subscribe($direct);

        //Break table Observer
        $treeBreak = new SmartTableBreakObserver($this->daoFactory);
        $this->subscribe($treeBreak);

        //Global Entry Observer
        $globalEntry = new SmartTableGlobalEntryObserver($this->daoFactory);
        $this->subscribe($globalEntry);

        $userTree = parent::execute($user, $owner, $parent, $level);
        return $userTree;
    }

    private function isRootUserAvailable() {
        $count = $this->daoFactory->getUserTreeDAO()->getCount(["type" => 0]);
        if ($count < 1) {
            throw new ZiletechException("Root user is missing in Tree for Smart Table");
        }
    }

}
