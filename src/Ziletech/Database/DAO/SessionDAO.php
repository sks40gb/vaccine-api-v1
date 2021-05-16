<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\Session;

class SessionDAO extends BaseDAO {

    public function __construct($entityManager) {
        parent::__construct($entityManager, Session::class);
    }

    public function getBySessionId($sessionId): ?Session {
        return $this->get(["sessionId" => $sessionId]);
    }

}
