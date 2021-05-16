<?php

namespace Ziletech\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="session")
 * */
class Session extends BaseEntity {

    /** @Id @Column(type="string", name="session_id) * */
    protected $sessionId;

    /** @Column(type="integer", name="available_capacity") * */
    protected $availableCapacity;

    /** @Column(type="integer", name="available_capacity_dose1") * */
    protected $availableCapacityDose1;

    /** @Column(type="integer", name="available_capacity_dose2") * */
    protected $availableCapacityDose2;

    /** @Column(type="date", name="date") * */
    protected $date;

    /** @Column(type="integer", name="min_age_limit") * */
    protected $minAgeLimit;

    /** @Column(type="string", name="vaccine") * */
    protected $vaccine;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="closed_at") * */
    protected $closed_at;

    /**
     * @ManyToOne(targetEntity="Center")
     * @JoinColumn(name="center_id", referencedColumnName="center_id")
     */
    protected $center;

    /**
     * @OneToMany(targetEntity="Slot", mappedBy="session", orphanRemoval=true)
     */
    protected $slots;

    function __construct() {
        $this->slots = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId($sessionId): void {
        $this->sessionId = $sessionId;
    }

    /**
     * @return mixed
     */
    public function getAvailableCapacity() {
        return $this->availableCapacity;
    }

    /**
     * @param mixed $availableCapacity
     */
    public function setAvailableCapacity($availableCapacity): void {
        $this->availableCapacity = $availableCapacity;
    }

    /**
     * @return mixed
     */
    public function getAvailableCapacityDose1() {
        return $this->availableCapacityDose1;
    }

    /**
     * @param mixed $availableCapacityDose1
     */
    public function setAvailableCapacityDose1($availableCapacityDose1): void {
        $this->availableCapacityDose1 = $availableCapacityDose1;
    }

    /**
     * @return mixed
     */
    public function getAvailableCapacityDose2() {
        return $this->availableCapacityDose2;
    }

    /**
     * @param mixed $availableCapacityDose2
     */
    public function setAvailableCapacityDose2($availableCapacityDose2): void {
        $this->availableCapacityDose2 = $availableCapacityDose2;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getMinAgeLimit() {
        return $this->minAgeLimit;
    }

    /**
     * @param mixed $minAgeLimit
     */
    public function setMinAgeLimit($minAgeLimit): void {
        $this->minAgeLimit = $minAgeLimit;
    }

    /**
     * @return mixed
     */
    public function getVaccine() {
        return $this->vaccine;
    }

    /**
     * @param mixed $vaccine
     */
    public function setVaccine($vaccine): void {
        $this->vaccine = $vaccine;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getClosedAt() {
        return $this->closed_at;
    }

    /**
     * @param mixed $closed_at
     */
    public function setClosedAt($closed_at): void {
        $this->closed_at = $closed_at;
    }

    /**
     * @return mixed
     */
    public function getCenter() {
        return $this->center;
    }

    /**
     * @param mixed $center
     */
    public function setCenter($center): void {
        $this->center = $center;
    }

    /**
     * @return ArrayCollection
     */
    public function getSlots(): ArrayCollection {
        return $this->slots;
    }

    /**
     * @param ArrayCollection $slots
     */
    public function setSlots(ArrayCollection $slots): void {
        $this->slots = $slots;
    }


    public function __toString() {
        return "Session[id: $this->sessionId]";
    }

}
