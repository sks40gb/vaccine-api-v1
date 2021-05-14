<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;

abstract class PlanService {

    /**
     *
     * @var ParentFinder
     */
    protected $parentFinder;

    /**
     * 
     * @var PositionLocator
     */
    protected $positionLocator;

    /**
     *
     * @var DAOFactory 
     */
    protected $daoFactory;

    /**
     * @var array
     */
    protected $observers = [];
    protected $type;

    public function __construct(DAOFactory $daoFactory, ParentFinder $parentFinder, PositionLocator $positionLocator, $type = 0) {
        $this->parentFinder = $parentFinder;
        $this->positionLocator = $positionLocator;
        $this->parentFinder->setPositionLocator($positionLocator);
        $this->daoFactory = $daoFactory;
        $this->type = $type;
    }

    function execute(User $user, ?User $owner, ?User $parent, $level= TreeConstant::LEVEL_FIRST): UserTree {
        //If item is root element
        $userTree = null;
        $root = $this->getRoot();
        //If the item is root elment then make first entry.
        if($parent == null || $root == null){
            $userTree = $this->addNewUserTree($user, $owner, null, null, $level);
        }else{
            $parentTree = $this->parentFinder->findParent($root, $parent);
            if($parentTree == null){
                throw new ZiletechException("No entry found in UserTree for provided parent $parentTree");
            }
            $position = $this->positionLocator->getPosition($parentTree);
            $userTree = $this->addNewUserTree($user, $owner, $parentTree, $position, $level);
        }
        //Get the fresh content
        $this->daoFactory->getUserTreeDAO()->refresh($userTree);
        $this->notify($userTree);
        return $userTree;
    }

    /**
     * Add New User Tree
     * @param type $user
     * @param type $ownerTree
     * @param type $parentTree
     * @param type $position
     * @return type
     */
    private function addNewUserTree(User $user, ?User $owner, ?UserTree $parentTree, $position, $level) : UserTree {
        //Add the User Tree
        $userTree = EntityFactory::getUserTree();
        $userTree->setUser($user);
        $userTree->setOwner($owner);
        $userTree->setParent($parentTree);
        //$parentTree->addChild($userTree);
        $userTree->setPosition($position);
        $userTree->setLevel($level);
        $userTree->setType($this->type);
        if($parentTree != null){
            $children = $parentTree->getChildren();
            $children->add($userTree);
        }
        $userTree = $this->daoFactory->getUserTreeDAO()->save($userTree);
        return $userTree;
    }

    public function subscribe(TreeObserver $observer): void {
        array_push($this->observers, $observer);
    }

    public function unsubscribe(TreeObserver $observer): void {
        foreach ($this->observers as $o) {
            if ($o === $observer) {
                unset($this->observers[$o]);
            }
        }
    }

    public function notify(UserTree $userTree = null): void {
        //echo "UserRepository: Broadcasting the '$event' event.\n";
        foreach ($this->observers as $observer) {
            $observer->update($this->positionLocator, $userTree);
        }
    }

    abstract public function getRoot(): ?UserTree;
}
