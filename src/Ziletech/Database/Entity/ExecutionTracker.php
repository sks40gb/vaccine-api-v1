<?php

namespace Ziletech\Database\Entity;


use DateTime;

/**
 * @Entity
 * @Table(name="execution_tracker")
 * */
class ExecutionTracker extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="type") * */
    protected $type;

    /** @Column(type="datetime", name="executed_at") * */
    protected $executedAt;

    /** @Column(type="integer", name="execution_time") * */
    protected $executionTime;

    /** @Column(type="boolean", name="completed") * */
    protected $completed;


    function __construct() {
        $this->completed = false;
        $this->executedAt = new DateTime();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void {
        $this->type = $type;
    }

    /**
     * @return DateTime
     */
    public function getExecutedAt(): DateTime {
        return $this->executedAt;
    }

    /**
     * @param DateTime $executedAt
     */
    public function setExecutedAt(DateTime $executedAt): void {
        $this->executedAt = $executedAt;
    }

    /**
     * @return mixed
     */
    public function getExecutionTime() {
        return $this->executionTime;
    }

    /**
     * @param mixed $executionTime
     */
    public function setExecutionTime($executionTime): void {
        $this->executionTime = $executionTime;
    }

    /**
     * @return boolean
     */
    public function getCompleted(): bool {
        return $this->completed;
    }

    /**
     * @param false $completed
     */
    public function setCompleted(bool $completed): void {
        $this->completed = $completed;
    }

    public function __toString() {
        return "ExecutionTracker[id: $this->id]";
    }

}
