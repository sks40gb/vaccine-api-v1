<?php

namespace Ziletech\Services\Plan\Binary;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Binary\Observer\DirectIncomeObserver;
use Ziletech\Services\Plan\Binary\Observer\MatchingBonusObserver;
use Ziletech\Services\Plan\Binary\Observer\UpdatePositionCountObserver;
use Ziletech\Services\Plan\Core\PlanService;
use Ziletech\Services\Plan\Core\TreeConstant;

class BinaryPlanService extends PlanService {

    public function __construct(DAOFactory $daoFactory) {
        $positionLocator = new BinaryPositionLocator();
        $parentFinder = new BinaryParentFinder($daoFactory, $positionLocator);
        parent::__construct($daoFactory, $parentFinder, $positionLocator, TreeConstant::TYPE_A);
    }

    public function getRoot(): ?UserTree {
        return $this->daoFactory->getUserTreeDAO()->getRootUser($this->type);
    }

    public function execute(User $user, ?User $owner, ?User $parent, $level = TreeConstant::LEVEL_FIRST): UserTree {

        //Update the position count.
        $updatePositionCount = new UpdatePositionCountObserver($this->daoFactory);
        $this->subscribe($updatePositionCount);

        //Direct Income
        $directIncome = new DirectIncomeObserver($this->daoFactory);
        $this->subscribe($directIncome);

        //Matching Income
        $matchingIncome = new MatchingBonusObserver($this->daoFactory);
        $this->subscribe($matchingIncome);

        $userTree = parent::execute($user, $owner, $parent, $level);
        return $userTree;
    }

}
