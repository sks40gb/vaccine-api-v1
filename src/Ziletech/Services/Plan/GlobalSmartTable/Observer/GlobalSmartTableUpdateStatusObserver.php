<?php

namespace Ziletech\Services\Plan\GlobalSmartTable\Observer;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\UserTree;
use Ziletech\Services\Plan\Core\PositionLocator;
use Ziletech\Services\Plan\Core\TreeConstant;
use Ziletech\Services\Plan\Core\TreeObserver;

class GlobalSmartTableUpdateStatusObserver implements TreeObserver {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function update(PositionLocator $positionLocator,UserTree $userTree) {
        $status = $this->updateSuperParentStatus($positionLocator, $userTree);
    }

    /**
     * Update the user status to complete[1] if it has all 6 members filled;
     * @param UserTree $userTree
     */
    function updateSuperParentStatus(PositionLocator $positionLocator, UserTree $userTree) {
        $status = TreeConstant::STATUS_INCOMPLETE;
        //Check if super parent is available
        if ($userTree->getParent() != null && $userTree->getParent()->getParent() != null) {
            $superParent = $userTree->getParent()->getParent();
            $status = TreeConstant::STATUS_COMPLETE;
            $length = sizeof($superParent->getChildren());
            if ($length == $positionLocator->getSize()) {
                foreach ($superParent->getChildren() as $tree) {
                    //$length = sizeof($tree->getChildren());
                    $length = sizeof($tree->getChildren());
                    if ($length != $positionLocator->getSize()) {
                        $status = TreeConstant::STATUS_INCOMPLETE;
                        break;
                    }
                }
            } else {
                $status = TreeConstant::STATUS_INCOMPLETE;
            }
            //Do not change the status of Root element
            if($superParent->getParent() != null){
                $superParent->setStatus($status);
            }
            $this->daoFactory->getUserTreeDAO()->update($superParent);
        }
        return $status;
    }

}
