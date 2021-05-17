<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DAO\ExecutionTrackerDAO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Database\Entity\ExecutionTracker;

class TrackerService {

    /**
     * @var ExecutionTrackerDAO
     */
    private $executionTrackerDAO;

    /**
     * @var ExecutionTracker
     */
    private $tracker;

    private $startTime;

    private $type;

    public function __construct(DAOFactory $daoFactory, $type) {
        $this->executionTrackerDAO = $daoFactory->getExecutionTrackerDAO();
        $this->type = $type;
    }

    public function start() {
        $this->startTime = microtime(true);
        $this->tracker = EntityFactory::getExecutionTracker();
        $this->tracker->setType($this->type);
        $this->tracker->setExecutedAt(new \DateTime());
        $this->tracker = $this->saveTacker();
    }

    public function close() {
        $this->tracker->setCompleted(true);
        $endTime = microtime(true);
        $this->tracker->setExecutionTime($endTime - $this->startTime);
        $this->tracker = $this->saveTacker();
    }

    public function closeOpenExecutions() {
        $tracker = $this->executionTrackerDAO->getActiveTracker(ExecutionTrackerDAO::THIRD_PARTY_CENTER);
        $tracker->setCompleted(true);
        $this->executionTrackerDAO->save($tracker);
    }

    private function saveTacker(): ExecutionTracker {
        return $this->executionTrackerDAO->save($this->tracker);
    }

    public function getActiveTracker(): ?ExecutionTracker {
        return $this->executionTrackerDAO->getActiveTracker(ExecutionTrackerDAO::THIRD_PARTY_CENTER);
    }


}
