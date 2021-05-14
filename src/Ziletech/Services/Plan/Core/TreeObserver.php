<?php

namespace Ziletech\Services\Plan\Core;

use Ziletech\Database\Entity\UserTree;

interface TreeObserver {

    public function update(PositionLocator $positionLocator, UserTree $userTree);
}
