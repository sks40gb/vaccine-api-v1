<?php

namespace Ziletech\Services\Plan\Core\Payout;

use Ziletech\Database\Entity\UserTree;

interface Payout {

    function pay(UserTree $userTree);
}
