<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\Entity\User;
use Ziletech\Database\Entity\UserTree;

abstract class ParentFinder {

    /**
     *
     * @var PositionLocator
     */
    protected $positionLocator;

    function __construct(PositionLocator $positionLocator) {
        $this->positionLocator = $positionLocator;
    }

    abstract function findParent(UserTree $root, User $owner): ?UserTree;
    
    function getPositionLocator(): PositionLocator {
        return $this->positionLocator;
    }

    function setPositionLocator(PositionLocator $positionLocator) {
        $this->positionLocator = $positionLocator;
    }


}
