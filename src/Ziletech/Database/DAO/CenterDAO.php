<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Center;

class CenterDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Center::class);
    }

    public function getByCenterId($centerId): ?Center {
        return $this->get(["centerId" => $centerId]);
    }

}
