<?php

namespace Ziletech\Services\Plan\SmartTable\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeObserver;
use Ziletech\Services\Plan\SmartTable\Payout\SmartTableDirectBonusPayout;

class SmartTableDirectObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /*
     * @var Payout
     */
    private $payout;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->payout = new SmartTableDirectBonusPayout($daoFactory);
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        $this->payout->pay($userTree);
    }

}
