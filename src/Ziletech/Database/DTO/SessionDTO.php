<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\Session;
use Ziletech\Database\Entity\Slot;

class SessionDTO {

    /**
     * @var string
     */
    public $sessionId;

    /**
     * @var integer
     */
    public $availableCapacity;

    /**
     * @var integer
     */
    public $availableCapacityDose1;

    /**
     * @var integer
     */
    public $availableCapacityDose2;

    /**
     * @var string
     */
    public $date;

    /**
     * @var integer
     */
    public $minAgeLimit;

    /**
     * @var string
     */
    public $vaccine;


    /**
     * @var DateTime
     */
    public $createdAt;


    /**
     * @var DateTime
     */
    public $closedAt;

    /**
     * @var Center
     */
    public $center;

    /**
     * @var Slot[]
     */
    public $slots = [];


    public function __construct(Session $session = null) {
        if (isset($session)) {
            $this->copyFromDomain($session);
        }
    }

    public function copyFromDomain(Session $session) {
        $this->sessionId = $session->getSessionId();
        $this->availableCapacity = $session->getAvailableCapacity();
        $this->availableCapacityDose1 = $session->getAvailableCapacityDose1();
        $this->availableCapacityDose2 = $session->getAvailableCapacityDose2();
        $this->date = $session->getDate();
        $this->minAgeLimit = $session->getMinAgeLimit();
        $this->vaccine = $session->getVaccine();
        $this->createdAt = $session->getCreatedAt();
        $this->closedAt = $session->getClosedAt();
        $this->center = $session->getCenter();
    }

    public function copyToDomain(Session $session) {
        $session->setSessionId($this->sessionId);
        $session->setAvailableCapacity($this->availableCapacity);
        $session->setAvailableCapacityDose1($this->availableCapacityDose1);
        $session->setAvailableCapacityDose2($this->availableCapacityDose2);
        $session->setDate($this->date);
        $session->setMinAgeLimit($this->minAgeLimit);
        $session->setVaccine($this->vaccine);
        $session->setCreatedAt($this->createdAt);
        $session->setClosedAt($this->closedAt);
        $session->setCenter($this->center);
    }

}
