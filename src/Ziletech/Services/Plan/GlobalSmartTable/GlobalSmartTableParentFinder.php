<?php

namespace Ziletech\Services\Plan\GlobalSmartTable;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\ParentFinder;

class GlobalSmartTableParentFinder extends ParentFinder {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function findParent(UserTree $root, User $owner): ?UserTree {
        $dummyQueue = new \SplQueue();
        $matchedTree = $this->findNodeBFS($root, $dummyQueue);

        if ($matchedTree == null) {
            throw new ZiletechException("No elibigible node is found under $root");
        }
        return $matchedTree;
    }

    private function findNodeBFS($userTree, $dummyQueue) {
        if ($userTree == null) {
            return null;
        }
        $childrenLength = sizeof($userTree->getChildren());
        if ($childrenLength < $this->positionLocator->getSize()) {
            return $userTree;
        }
        foreach ($userTree->getChildren() as $child) {
            $dummyQueue->enqueue($child);
        }
        if (!($dummyQueue->isEmpty())) {
            $next = $dummyQueue->dequeue();
            return $this->findNodeBFS($next, $dummyQueue);
        }
        return null;
    }

}
