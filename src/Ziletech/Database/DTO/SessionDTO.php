<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\Center;
use Ziletech\Database\Entity\Session;

class SessionDTO {

    /**
     * @var integer
     */
    public $id;

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
     * @var DateTime
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
     * @var boolean
     */
    public $closed;

    /**
     * @var Center
     */
    public $center;

    /**
     * @var string[]
     */
    public $slots = [];


    public function __construct(Session $session = null) {
        if (isset($session)) {
            $this->copyFromDomain($session);
        }
    }

    public function copyFromDomain(Session $session) {
        $this->id = $session->getId();
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
        $this->closed = $session->getClosed();
    }

    public function copyToDomain(Session $session) {
        $session->setId($this->id);
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
        $session->setClosed($this->closed);
    }

    /**
     * @return string
     */
    public function getSessionId(): string {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId): void {
        $this->sessionId = $sessionId;
    }

    /**
     * @return int
     */
    public function getAvailableCapacity(): int {
        return $this->availableCapacity;
    }

    /**
     * @param int $availableCapacity
     */
    public function setAvailableCapacity(int $availableCapacity): void {
        $this->availableCapacity = $availableCapacity;
    }

    /**
     * @return int
     */
    public function getAvailableCapacityDose1(): int {
        return $this->availableCapacityDose1;
    }

    /**
     * @param int $availableCapacityDose1
     */
    public function setAvailableCapacityDose1(int $availableCapacityDose1): void {
        $this->availableCapacityDose1 = $availableCapacityDose1;
    }

    /**
     * @return int
     */
    public function getAvailableCapacityDose2(): int {
        return $this->availableCapacityDose2;
    }

    /**
     * @param int $availableCapacityDose2
     */
    public function setAvailableCapacityDose2(int $availableCapacityDose2): void {
        $this->availableCapacityDose2 = $availableCapacityDose2;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getMinAgeLimit(): int {
        return $this->minAgeLimit;
    }

    /**
     * @param int $minAgeLimit
     */
    public function setMinAgeLimit(int $minAgeLimit): void {
        $this->minAgeLimit = $minAgeLimit;
    }

    /**
     * @return string
     */
    public function getVaccine(): string {
        return $this->vaccine;
    }

    /**
     * @param string $vaccine
     */
    public function setVaccine(string $vaccine): void {
        $this->vaccine = $vaccine;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getClosedAt(): DateTime {
        return $this->closedAt;
    }

    /**
     * @param DateTime $closedAt
     */
    public function setClosedAt(DateTime $closedAt): void {
        $this->closedAt = $closedAt;
    }

    /**
     * @return Center
     */
    public function getCenter(): Center {
        return $this->center;
    }

    /**
     * @param Center $center
     */
    public function setCenter(Center $center): void {
        $this->center = $center;
    }

    /**
     * @return string[]
     */
    public function getSlots(): array {
        return $this->slots;
    }

    /**
     * @param string[] $slots
     */
    public function setSlots(array $slots): void {
        $this->slots = $slots;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void {
        $this->closed = $closed;
    }


}
