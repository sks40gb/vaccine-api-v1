<?php

namespace Ziletech\Services\Plan\Binary\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Binary\Payout\MatchingBonusPayout;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeObserver;

class MatchingBonusObserver implements TreeObserver {

    const LEFT = 1;
    const RIGHT = 2;

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /*
     * @var MatchingBonusPayout
     */
    private $payout;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->payout = new MatchingBonusPayout($daoFactory);
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        $this->payoutRecusively($userTree);
    }

    private function payoutRecusively(UserTree $userTree) {
        $parentTree = $userTree->getParent();
        //do nothing for root item
        if ($parentTree == null) {
            return;
        }

        $position = $userTree->getPosition();

        $leftCount = $this->getCount($parentTree, Self::LEFT);
        $rightCount = $this->getCount($parentTree, Self::RIGHT);

        //Do nothing if the left and right count is 0
        if ($leftCount != 0 && $rightCount != 0) {
            if ($position == Self::LEFT && $leftCount <= $rightCount) {
                $this->payout->pay($userTree);
            } else if ($position == Self::RIGHT && $leftCount >= $rightCount) {
                $this->payout->pay($userTree);
            }
        }
        $this->payoutRecusively($parentTree);
    }

    private function getCount(UserTree $userTree, $position) {
        $userPosition = $this->daoFactory->getUserPositionDAO()->getByUserAndPosition($userTree, $position);
        if ($userPosition == null) {
            return 0;
        }
        return $userPosition->getPosition();
    }

}
