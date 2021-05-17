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

    private const TIMEOUT_SECONDS = 60;

    public function __construct(DAOFactory $daoFactory, $type) {
        $this->executionTrackerDAO = $daoFactory->getExecutionTrackerDAO();
        $this->type = $type;
    }

    public function start() {
        $this->startTime = microtime(true);
        $this->tracker = EntityFactory::getExecutionTracker();
        $this->tracker->setCategory($this->type);
        $this->tracker->setExecutedAt(new \DateTime());
        $this->tracker = $this->saveTacker();
    }

    public function close() {
        $this->tracker->setCompleted(true);
        $endTime = microtime(true);
        $this->tracker->setExecutionTime($endTime - $this->startTime);
        $this->tracker = $this->saveTacker();
    }

    public function autoCloseConnection() {
        $tracker = $this->executionTrackerDAO->getActiveTracker(ExecutionTrackerDAO::THIRD_PARTY_CENTER);
        if ($tracker != null) {
            $currentDate = new \DateTime();
            $seconds = TimeService::getDiffInSeconds($tracker->getExecutedAt(), $currentDate);
            if ($seconds > self::TIMEOUT_SECONDS) {
                $tracker->setCompleted(true);
                $this->executionTrackerDAO->save($tracker);
            }
        }
    }

    private function saveTacker(): ExecutionTracker {
        return $this->executionTrackerDAO->save($this->tracker);
    }

    public function getActiveTracker(): ?ExecutionTracker {
        return $this->executionTrackerDAO->getActiveTracker(ExecutionTrackerDAO::THIRD_PARTY_CENTER);
    }


}
