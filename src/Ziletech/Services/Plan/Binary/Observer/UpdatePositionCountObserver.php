<?php

namespace Ziletech\Services\Plan\Binary\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserPosition;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeObserver;

class UpdatePositionCountObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        $this->updatePositionRecusive($userTree);
    }

    private function updatePositionRecusive(UserTree $userTree) {
        //If parent is root then do nothing
        $parentTree = $userTree->getParent();
        if ($parentTree == null) {
            return;
        }
        $position = $userTree->getPosition();
        $userPosition = $this->daoFactory->getUserPositionDAO()->getByUserAndPosition($parentTree, $position);
        if ($userPosition == null) {
            $userPosition = new UserPosition();
            $userPosition->setUserTree($parentTree);
            $userPosition->setPosition($position);
            $userPosition->setCount(1);
            $this->daoFactory->getUserPositionDAO()->save($userPosition);
        } else {
            $userPosition->setCount($userPosition->getCount() + 1);
            $this->daoFactory->getUserPositionDAO()->update($userPosition);
        }
        $this->updatePositionRecusive($parentTree);
    }

}
