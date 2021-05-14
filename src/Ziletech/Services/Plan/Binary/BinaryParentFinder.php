<?php

namespace Ziletech\Services\Plan\Binary;

use SplQueue;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;
use Ziletech\Services\Plan\Core\ParentFinder;
use Ziletech\Services\Plan\Core\TreeConstant;

class BinaryParentFinder extends ParentFinder {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    function findParent(UserTree $root, User $owner): ?UserTree {

        $parentTree = $this->getLatestUserTree($owner);
        
        if ($parentTree == null) {
            throw new ZiletechException("UserTree is not found for user $owner. Hint:Check if status is 0.");
        }

        $dummyQueue = new SplQueue();
        $matchedTree = $this->findNodeBFS($parentTree, $dummyQueue);

        if ($matchedTree == null) {
            throw new ZiletechException("Eligible child node is not found for owner $owner in tree root $root.");
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

    function getLatestUserTree(User $user) {
        $currentTree = $this->daoFactory->getUserTreeDAO()->getByUserAndStatus($user, TreeConstant::STATUS_INCOMPLETE);
        return $currentTree;
    }

}
