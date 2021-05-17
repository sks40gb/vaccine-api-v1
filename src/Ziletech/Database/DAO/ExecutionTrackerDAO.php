<?php

namespace Ziletech\Database\DAO;

use BaseDAO;
use Ziletech\Database\Entity\ExecutionTracker;

class ExecutionTrackerDAO extends BaseDAO {

    public const THIRD_PARTY_CENTER = "THIRD PARTY CENTER";

    public function __construct($entityManager) {
        parent::__construct($entityManager, ExecutionTracker::class);
    }

    public function getActiveTracker($type): ?ExecutionTracker {
        return $this->get(["type" => $type, "completed" => false]);
    }
}
