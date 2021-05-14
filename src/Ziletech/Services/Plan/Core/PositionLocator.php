<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\Entity\UserTree;
use Ziletech\Exceptions\ZiletechException;

abstract class PositionLocator {

    function getPosition(UserTree $parentTree) {
        $childrenLength = sizeof($parentTree->getChildren());
        if ($childrenLength == $this->getSize()) {
            throw new ZiletechException("Tree $parentTree is already full. No position left.");
        }
        return $childrenLength + 1;
    }

    abstract function getSize();
}
