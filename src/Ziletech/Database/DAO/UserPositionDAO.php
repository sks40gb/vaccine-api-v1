<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\UserPosition;
use Ziletech\Database\Entity\UserTree;

class UserPositionDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, UserPosition::class);
    }

    public function getByUserAndPosition(?UserTree $userTree, $position): ?UserPosition {
        return $this->get(["userTree" => $userTree, "position" => $position]);
    }

}
