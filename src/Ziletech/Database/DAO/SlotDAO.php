<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\Slot;

class SlotDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Slot::class);
    }

    public function getById($id): ?Center {
        return $this->get(["id" => $id]);
    }

}
