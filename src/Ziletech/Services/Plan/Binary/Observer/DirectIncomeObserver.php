<?php

namespace Ziletech\Services\Plan\Binary\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Binary\Payout\DirectBonusPayout;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeObserver;

class DirectIncomeObserver implements TreeObserver {

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
        $this->payout = new DirectBonusPayout($daoFactory);
    }

    public function update(PositionLocator $positionLocator, UserTree $userTree) {
        $this->payout->pay($userTree);
    }

}
